<?php

namespace App\Enum\Notification;

enum NotificationTypeEnum: string
{
    case Success = 'success';
    case Info = 'info';
    case Warning = 'warning';
}
