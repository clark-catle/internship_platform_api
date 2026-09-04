<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Auth\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequests\CreateTokenForAdminCreation;
use App\Http\Requests\AdminRequests\RegisterAdminRequest;
use App\Http\Resources\UserResource;
use App\Services\AdminCreationService;
use Dedoc\Scramble\Attributes\Endpoint;

class AdminCreationController extends Controller
{
    public function __construct(private AdminCreationService $adminCreateService)
    {
        //
    }

    #[Endpoint(title: 'Create Admin', description: 'The admin can create a admin creation token that will be used for user creation that role is an admin')]
    public function createToken(CreateTokenForAdminCreation $request)
    {
        $email = $request->validated()['email'];

        $url = $this->adminCreateService->createToken($email);

        return response()->json([
            'message' => 'Url has been created and was sent successfully, this will expire in 30 minutes',
            'url' => $url
        ]);
    }

    public function registerAdmin(RegisterAdminRequest $request)
    {
        $validated = $request->validated();
        $data = RegisterDTO::createAdmin($validated['email'], $validated['password']);

        $newUser = $this->adminCreateService
            ->registerAdmin($data, $validated['token']);

        return UserResource::make($newUser);
    }
}
