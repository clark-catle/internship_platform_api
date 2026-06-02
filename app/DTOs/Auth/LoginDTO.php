<?php

namespace App\DTOs\Auth;

use App\Http\Requests\AuthRequest\LoginRequest;

class LoginDto
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {}

    public static function fromRequest(LoginRequest $request)
    {
        $validated = $request->validated();

        return new self(
            email: $validated['email'],
            password: $validated['password'],
        );
    }
}
