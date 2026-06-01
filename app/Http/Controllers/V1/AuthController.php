<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        return $request->validated();
    }

    public function register(RegisterRequest $request)
    {
        return $request->validated();
    }
}
