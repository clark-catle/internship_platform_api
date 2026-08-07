<?php

namespace App\Repositories;

use App\Enum\User\UserRoleEnum;
use App\Models\User;

class UserRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private User $user) {}
}
