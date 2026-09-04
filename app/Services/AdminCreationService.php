<?php

namespace App\Services;

use App\DTOs\Auth\RegisterDTO;
use App\Mail\AdminMail\AdminCreationMail as AdminMailAdminCreationMail;
use App\Models\AdminCreation;
use App\Repositories\AdminCreationRepository;
use App\Repositories\AuthRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class AdminCreationService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private AdminCreationRepository $adminCreateRepo,
        private AuthRepository $authRepo
    ) {
        //
    }

    /**
     * creates an url and send the url with token in the `$email`
     * of the user and returning it
     * @param string $email
     * @return string
     */
    public function createToken(string $email)
    {
        $token = Str::random(64);
        $url =  config('app.frontend_url') . "/registerAdmin/$token";

        DB::transaction(function () use ($token, $email, $url) {
            $this->adminCreateRepo->createAdminCreationToken($token);

            Mail::to($email)->send(new AdminMailAdminCreationMail($email, $url));
        });

        return $url;
    }

    /**
     * register thhe new user base on the info in `$data`, this should
     * already have a admin role, before proceeding, it will check
     * if the `$token` is already used or already expired for validation,
     * didnt add the "if token exists" because the RegisterAdminRequest
     * request already handles that, then it will delete theh token
     * first before proceeding with the registration then retuns it
     * @param RegisterDTO $data
     * @param string $token
     * @throws Exception
     * @return User
     */
    public function registerAdmin(RegisterDTO $data, string $token)
    {
        $tokenInfo = $this->adminCreateRepo->findToken($token);

        if (filled($tokenInfo->used_at))
            throw new Exception('The token is already used!');

        if ($tokenInfo->expires_at->isBefore(now()))
            throw new Exception('The token is already expired!');

        return DB::transaction(function () use ($data, $tokenInfo) {
            $this->adminCreateRepo->removeAdminCreation($tokenInfo);

            return $this->authRepo->create($data);
        });
    }

    /**
     * returnn all the info of Admin Creation table
     * @return \Illuminate\Database\Eloquent\Collection<int, AdminCreation>
     */
    public function viewAllToken()
    {
        return $this->adminCreateRepo->viewAll();
    }

    /**
     * removes the `$info` record in the database
     * @param AdminCreation $info
     * @return void
     */
    public function deleteToken(AdminCreation $info)
    {
        DB::transaction(fn() => $this->adminCreateRepo->removeAdminCreation($info));
    }
}
