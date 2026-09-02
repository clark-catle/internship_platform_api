<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function userNotification(User $user, DatabaseNotification $notification)
    {
        return $user->id === $notification->notifiable_id;
    }
}
