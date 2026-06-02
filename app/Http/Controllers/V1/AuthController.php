<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService,
    ) {}

    public function register(RegisterRequest $request)
    {
        $val = $this->authService->register(RegisterDTO::fromRequest($request));

        return response()->json([
            'message' => 'Successfully created an account, check your gmail for email verification',
            'user' => UserResource::make($val)
        ]);
    }

    public function login(LoginRequest $request)
    {
        $val = $this->authService->login(LoginDTO::fromRequest($request));

        return response()->json([
            'message' => 'Successfully logged in',
            'token' => $val['token'],
            'user' => UserResource::make($val['user']),
        ]);
    }
}
