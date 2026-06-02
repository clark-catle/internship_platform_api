<?php

namespace App\Repositories;

use App\DTOs\Auth\RegisterDTO;
use App\Models\User;

class AuthRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private User $user) {}

    /**
     * creates a new `User` model base on the passed `$data` then returning it
     * @param RegisterDTO $data
     * @return User
     */
    public function create(RegisterDTO $data)
    {
        return $this->user->create([
            'email' => $data->email,
            'password' => $data->password,
            'role' => $data->role
        ])->refresh();
    }

    public function findByEmail(string $email)
    {
        return $this->user->where('email', $email)->first();
    }
}
