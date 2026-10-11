<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\ChangeEmailRequest;
use App\Services\UserService;

class EmailController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function sendChangeEmail(ChangeEmailRequest $request)
    {
        $email = $request->validated()['email'];
        $user = request()->user();

        $this->userService->changeEmail($email, $user);
    }
}
