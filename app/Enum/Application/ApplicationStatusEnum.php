<?php

namespace App\Enum\Application;

enum ApplicationStatusEnum: string
{
    case Pending = 'pending';
    case InReview = 'in review';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
}
