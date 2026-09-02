<?php

namespace App\Repositories;

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
}
