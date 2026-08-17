<?php

namespace App\Services;

use App\DTOs\User\ResetPasswordDTO;
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

    /**
     * send a email to the user's `$email` for a reset password link
     * @param string $email
     */
    public function sendForgotPassword(string $email)
    {
        return DB::transaction(function () use ($email) {
            $status = Password::sendResetLink(['email' => $email]);

            if ($status !== Password::RESET_LINK_SENT)
                throw new Exception($status);

            return $status;
        });
    }

    /**
     * resets the password of the user that is connected to the 
     * token inside the `$data` then deleted the token of that user
     * @param ResetPasswordDTO $data
     */
    public function resetPassword(ResetPasswordDTO $data)
    {
        return DB::transaction(function () use ($data) {
            $status = Password::reset($data->toArray(), function (User $user, string $password) {
                $this->userRepo->changePassword($user, $password);

                $this->logout($user);
            });

            if ($status !== Password::PASSWORD_RESET)
                throw new Exception($status);

            return $status;
        });
    }

    /**
     * logouts the `$user` by deleting the its current token
     * @param User $user
     * @return void
     */
    public function logout(User $user)
    {
        $user->tokens()->delete();
    }
}
