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
}
