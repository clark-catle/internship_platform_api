<?php

namespace App\Policies;

use App\Enum\User\UserRoleEnum;
use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * checks if `$user` is created much more earlier than the `$target`,
     * will return false if `$user` and `$target` is the same
     * @param User $user
     * @param User $target
     * @return bool
     */
    public function seniorityRule(User $user, User $target)
    {
        return $user->created_at->isBefore($target->created_at);
    }

    /**
     * check of `$user` and `$target` is the same user
     * @param User $user
     * @param User $target
     * @return bool
     */
    public function sameUser(User $user, User $target)
    {
        return $user->id === $target->id;
    }

    public function changeStatus(User $user, User $target)
    {
        if (
            $target->role === UserRoleEnum::Admin &&
            !$this->seniorityRule($user, $target)
        )
            return false;


        return true;
    }
}
