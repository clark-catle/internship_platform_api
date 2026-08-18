<?php

namespace App\DTOs\User;

use App\Http\Requests\UserRequests\ChangePasswordRequest;

class ChangePasswordDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $oldPassword,
        public readonly string $newPassword,
    ) {}

    public static function fromRequest(ChangePasswordRequest $request)
    {
        $validated = $request->validated();

        return new self(
            oldPassword: $validated['oldPassword'],
            newPassword: $validated['newPassword']
        );
    }
}
