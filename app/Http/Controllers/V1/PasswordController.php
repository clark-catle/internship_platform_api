<?php

namespace App\Http\Controllers\V1;

use App\DTOs\User\ChangePasswordDTO;
use App\DTOs\User\ResetPasswordDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\ChangePasswordRequest;
use App\Http\Requests\UserRequests\ForgotPasswordRequest;
use App\Http\Requests\UserRequests\ResetPasswordRequest;
use App\Services\UserService;
use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Http\Request;

class PasswordController extends Controller
{

    public function __construct(private UserService $userService) {}

    #[Endpoint(title: 'Forgot password', description: 'The user can request the forgot password and the link will be passed in the user\'s email that was indicated')]
    public function sendForgotPassword(ForgotPasswordRequest $request)
    {
        $this->userService->sendForgotPassword($request->validated()['email']);

        return response()->json([
            'message' => 'Password reset link was sent to the given email',
        ]);
    }

    #[Endpoint(title: 'Reset password', description: 'The user can change their password by pass a proper token and credential like email and password')]
    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = ResetPasswordDTO::fromRequest($request);

        $this->userService->resetPassword($data);

        return response()->json([
            'message' => 'The password has been changed successfully!',
        ]);
    }

    #[Endpoint(title: 'Change password', description: 'The user can change their password by passing the old password for validation then change it, then delete the current token of the user for force relogin')]
    public function changePassword(ChangePasswordRequest $request)
    {
        $data = ChangePasswordDTO::fromRequest($request);
        $user = $request->user();

        $this->userService->changePassword($user, $data);

        return response()->json([
            'message' => 'The password has been changed successfully!',
        ]);
    }

    todo list:
    added report intern and application and the admin can view the reports and make an action about it
}
