<?php

namespace App\Http\Controllers\V1;

use App\Enum\User\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\AdminCreationRequest;
use App\Http\Requests\UserRequests\UserChangeStatusRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Dedoc\Scramble\Attributes\Endpoint;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    #[Endpoint(title: 'Change user status', description: 'The user admin can change the targeted user status, this has a seniority policy where the user cant update the admin that is older than the user, the user cant also change its status, after the change it will take a job where it will send a email to the target user')]
    public function userChangeStatus(UserChangeStatusRequest $request, User $user)
    {
        $this->authorize('changeStatus', $user);

        $status = UserStatusEnum::from($request->validated()['status']);
        $user = $this->userService->userChangeStatus($status, $user);

        return UserResource::make($user);
    }

    #[Endpoint(title: 'Create Admin', description: 'The admin can create a admin creation token that will be used for user creation that role is an admin')]
    public function createAdmin(AdminCreationRequest $request)
    {
        $email = $request->validated()['email'];

        $url = $this->userService->createAdmin($email);

        return response()->json([
            'message' => 'Url has been created and was sent successfully, this will expire in 30 minutes',
            'url' => $url
        ]);
    }
}
