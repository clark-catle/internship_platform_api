<?php

namespace App\DTOs\User;

use App\Http\Requests\UserRequests\ResetPasswordRequest;

class ResetPasswordDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $token,
        public readonly string $email,
        public readonly string $password,
    ) {}

    public static function fromRequest(ResetPasswordRequest $request)
    {
        return new self(
            token: $request->string('token'),
            email: $request->string('email'),
            password: $request->string('password'),
        );
    }

    public function toArray()
    {
        return [
            'token' => $this->token,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
