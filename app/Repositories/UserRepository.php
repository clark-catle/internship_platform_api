<?php

namespace App\Repositories;

use App\Enum\User\UserRoleEnum;
use App\Enum\User\UserStatusEnum;
use App\Models\User;

class UserRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private User $user) {}

    /**
     * update the status of the `$user` base on the passed `$status`
     * @param UserStatusEnum $status
     * @param User $user
     * @return void
     */
    public function changeStatus(UserStatusEnum $status, User $user)
    {
        $user->update(['status' => $status]);
    }

    /**
     * change the password of the `$user` base on the passed `$password`, 
     * automatically hashed because was defined in user model
     * @param User $user
     * @param string $password
     * @return void
     */
    public function changePassword(User $user, string $password)
    {
        $user->update(['password' => $password]);
    }
}
