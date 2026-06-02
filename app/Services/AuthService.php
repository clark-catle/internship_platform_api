<?php

namespace App\Services;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Jobs\SendWelcomeEmailJob;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private AuthRepository $authRepo,
    ) {}

    /**
     * regestering the new user then sending the email verification 
     * for the newly created user and then return the new user info
     * @param RegisterDTO $data
     */
    public function register(RegisterDTO $data)
    {
        return DB::transaction(function () use ($data) {
            $newUser = $this->authRepo->create($data);

            SendWelcomeEmailJob::dispatch($newUser);

            return $newUser;
        });
    }

    /**
     * logging in the user then abort if the credentials is incorect otherwise it will return a token
     * @param LoginDTO $data
     * @return array{token: string, user: \App\Models\User}
     */
    public function login(LoginDTO $data)
    {
        $correctCredentials = Auth::attempt(['email' => $data->email, 'password' => $data->password]);

        abort_if(!$correctCredentials, 404, 'User email or password is incorrect');

        $user = Auth::user();

        return [
            'token' => $user->createToken('main')->plainTextToken,
            'user' => $user
        ];
    }
}
