<?php

namespace App\Repositories;

use App\Models\AdminCreation;

class AdminCreationRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private AdminCreation $adminCreation)
    {
        //
    }

    /**
     * creates a token base on the passed `$token` and adds an
     * expiration that will expire in 30 minutes
     * @param string $token
     * @return AdminCreation
     */
    public function createAdminCreationToken(string $token)
    {
        return $this->adminCreation::create([
            'token' => $token,
            'expires_at' => now()->addMinutes(30)
        ]);
    }

    /**
     * deletes the `$token` in admin creation table
     * @param string $token
     * @return void
     */
    public function removeAdminCreationByToken(string $token)
    {
        $this->adminCreation->where('token', $token)->delete();
    }

    /**
     * gets the info in Admin Creation Table by its '$token' value
     * @param string $token
     * @return AdminCreation|\stdClass|null
     */
    public function findToken(string $token)
    {
        return $this->adminCreation->where('token', $token)->first();
    }

    /**
     * removes the `$info` record in the database
     * @param AdminCreation $info
     * @return void
     */
    public function removeAdminCreation(AdminCreation $info)
    {
        $info->delete();
    }
}
