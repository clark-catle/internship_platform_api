<?php

namespace App\DTOs\User;

use App\Http\Requests\AdminRequests\RegisterAdminRequest;

class RegisterAdminDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $token,
    ) {}

    public static function fromRequest(RegisterAdminRequest $request)
    {
        $valid = $request->validated();

        return new self(
            email: $valid['email'],
            password: $valid['password'],
            token: $valid['token'],
        );
    }
}
