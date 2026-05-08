<?php

namespace App\Enum\Report;

enum ReportStatusEnum: string
{
    case Pending = 'pending';
    case Reviewd = 'reviewed';
    case Resolved = 'resolved';
    case Rejected = 'rejected';
}
