<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function __construct(private NotificationService $notifService)
    {
        //
    }

    public function getAllNotification()
    {
        $user = request()->user();

        $notifications = $this->notifService->getAllNotification($user);

        return NotificationResource::collection($notifications);
    }
}
