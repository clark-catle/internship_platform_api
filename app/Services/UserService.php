<?php

namespace App\Services;

use App\Enum\User\UserRoleEnum;
use App\Enum\User\UserStatusEnum;
use App\Jobs\UserJobs\ChangeUserStatusMailJob;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private UserRepository $userRepo) {}

    /**
     * change the status of `$user` base on the passed `$status`
     * @param UserStatusEnum $status
     * @param User $user
     * @return User
     */
    public function userChangeStatus(UserStatusEnum $status, User $user)
    {
        return DB::transaction(function () use ($status, $user) {
            $this->userRepo->changeStatus($status, $user);

            ChangeUserStatusMailJob::dispatch($user);

            $load = null;

            if ($user->role === UserRoleEnum::Student)
                $load = [
                    'student',
                    'student.course',
                    'student.skill',
                ];
            else if ($user->role === UserRoleEnum::Company)
                $load = ['company'];

            if ($load)
                return $user->load($load);

            return $user;
        });
    }

    public function sendResetPassword(string $email)
    {
        $status = Password::sendResetLink(['email' => $email]);

        if ($status !== Password::RESET_LINK_SENT)
            throw new Exception($status);

        return $status;
    }
}
