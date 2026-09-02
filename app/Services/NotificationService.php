<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\NotificationRepository;

class NotificationService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private NotificationRepository $notifRepo)
    {
        //
    }

    /**
     * Summary of getAllNotification
     * @param User $user
     * @return \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification>
     */
    public function getAllNotification(User $user)
    {
        return $user->notifications;
    }
}
