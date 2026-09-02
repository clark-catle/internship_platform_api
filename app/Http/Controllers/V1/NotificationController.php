<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Services\NotificationService;
use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{

    public function __construct(
        private NotificationService $notifService,
    ) {
        //
    }

    #[Endpoint(title: 'User view all notification', description: 'The user can all see its notification info')]
    public function getAllNotification()
    {
        $user = request()->user();

        $notifications = $this->notifService->getAllNotification($user);

        return NotificationResource::collection($notifications);
    }

    #[Endpoint(title: 'User unread notification count', description: 'The user can get the count of unread notification')]
    public function unreadCount()
    {
        $user = request()->user();

        $count = $this->notifService->unreadCount($user);

        return response()->json([
            'unread_count' => $count
        ]);
    }

    #[Endpoint(title: 'User view specific notification', description: 'The user can view the specific notification and that notification will be marked as read')]
    public function markAsRead(DatabaseNotification $notif)
    {
        $this->authorize('userNotification', $notif);

        $this->notifService->markAsRead($notif);

        return NotificationResource::make($notif);
    }

    public function markAllRead()
    {
        $user = request()->user();

        $this->notifService->markAllRead($user);

        return response()->json([
            'message' => "All unread notification has been marked as read"
        ]);
    }
}
