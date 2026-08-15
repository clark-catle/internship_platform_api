<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\PasswordResetRequest;
use App\Services\UserService;
use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Http\Request;

class PasswordController extends Controller
{

    public function __construct(private UserService $userService) {}

    #[Endpoint(title: 'Reset password', description: 'The user can request the forgot password and the link will be passed in the user\'s email that was indicated')]
    public function sendResetPassword(PasswordResetRequest $request)
    {
        $this->userService->sendResetPassword($request->validated()['email']);

        return response()->json([
            'message' => 'Password reset link was sent to the given email',
        ]);
    }
}
