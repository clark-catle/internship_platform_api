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
     * returns the count of unread notification the `$user` has
     * @param User $user
     * @return int
     */
    public function unreadCount(User $user)
    {
        return $user->unreadNotifications()->count();
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

    /**
     * all the unread notification of `$user` will be marked as read
     * @param User $user
     * @return void
     */
    public function markAllRead(User $user)
    {
        DB::transaction(fn() => $this->notifRepo->markAllRead($user));
    }

    /**
     * deletes the `$notif`
     * @param DatabaseNotification $notif
     * @return void
     */
    public function deleteNotif(DatabaseNotification $notif)
    {
        DB::transaction(fn() => $this->notifRepo->deleteNotif($notif));
    }
}
