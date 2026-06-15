<?php

namespace App\DTOs\Auth;

use App\Enum\User\UserRoleEnum;
use App\Http\Requests\AuthRequests\RegisterRequest;

class RegisterDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly UserRoleEnum $role,
    ) {}

    public static function fromRequest(RegisterRequest $request)
    {
        $validated = $request->validated();

        return new self(
            email: $validated['email'],
            password: $validated['password'],
            role: UserRoleEnum::from($validated['role']),
        );
    }
}
