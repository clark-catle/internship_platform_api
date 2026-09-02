<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class NotificationRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * it marks the passed `$notif` as read
     * @param DatabaseNotification $notif
     * @return void
     */
    public function markAsRead(DatabaseNotification $notif)
    {
        $notif->markAsRead();
    }

    public function markAllRead(User $user)
    {
        $user->unreadNotifications()
            ->where('read_at', null)
            ->update(['read_at' => now()]);
    }
}
