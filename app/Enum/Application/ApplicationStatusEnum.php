<?php

namespace App\Enum\Application;

enum ApplicationStatusEnum: string
{
    case Pending = 'pending';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
}
