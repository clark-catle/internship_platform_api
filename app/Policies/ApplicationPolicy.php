<?php

namespace App\Policies;

use App\Models\Internship;
use App\Models\User;

class ApplicationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    /**
     * checks if the `$user` already has a student info
     * @param User $user
     * @return bool
     */
    public function apply(User $user)
    {
        return $user->student()->exists();
    }
}
