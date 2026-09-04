<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Auth\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequests\CreateTokenForAdminCreation;
use App\Http\Requests\AdminRequests\RegisterAdminRequest;
use App\Http\Resources\AdminCreationResource;
use App\Http\Resources\UserResource;
use App\Models\AdminCreation;
use App\Services\AdminCreationService;
use Dedoc\Scramble\Attributes\Endpoint;

class AdminCreationController extends Controller
{
    public function __construct(private AdminCreationService $adminCreateService)
    {
        //
    }

    public function viewTokens()
    {
        $data =  $this->adminCreateService->viewAllToken();

        return response()->json([
            'data' =>  AdminCreationResource::collection($data),
            'frontend_url' => config('app.frontend_url') . "/registerAdmin/"
        ]);
    }

    #[Endpoint(title: 'Create Token for Admin Acc Creation', description: 'The admin can create a admin creation token that will be used for user creation that role is an admin')]
    public function createToken(CreateTokenForAdminCreation $request)
    {
        $email = $request->validated()['email'];

        $url = $this->adminCreateService->createToken($email);

        return response()->json([
            'message' => 'Url has been created and was sent successfully to the email provided, this will expire in 30 minutes!',
            'url' => $url
        ]);
    }

    #[Endpoint(title: 'Register as an Admin', description: 'The new user that will be created will automatically be an admin as long as the passed token is valid, not used, and not expired')]
    public function registerAdmin(RegisterAdminRequest $request)
    {
        $validated = $request->validated();
        $data = RegisterDTO::createAdmin($validated['email'], $validated['password']);

        $newUser = $this->adminCreateService
            ->registerAdmin($data, $validated['token']);

        return UserResource::make($newUser);
    }

    #[Endpoint(title: 'Delete token', description: 'The admin can delete a token manually')]
    public function deleteToken(AdminCreation $adminCreation)
    {
        $this->adminCreateService->deleteToken($adminCreation);

        return response()->json([
            'message' => 'The token has been deleted successfully!',
        ]);
    }

    // viewing of own profile should be used in a single api
}
