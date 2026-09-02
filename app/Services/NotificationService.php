<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\NotificationRepository;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private NotificationRepository $notifRepo,)
    {
        //
    }

    /**
     * Summary of getAllNotification
     * @param User $user
     * @return \Illuminate\Notifications\DatabaseNotificationCollection<DatabaseNotification>
     */
    public function getAllNotification(User $user)
    {
        return $user->notifications;
    }

    /**
     * mark the `$notif` as read
     * @param DatabaseNotification $notif
     * @return void
     */
    public function markAsRead(DatabaseNotification $notif)
    {
        DB::transaction(fn() => $this->notifRepo->markAsRead($notif));
    }
}
