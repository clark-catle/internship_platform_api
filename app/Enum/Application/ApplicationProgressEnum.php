<?php

namespace App\Enum\Application;

enum ApplicationProgressEnum: string
{
    case Applied = 'applied';
    case InReview = 'in review';
    case Interview = 'interview';
    case Decision = 'decision';
}
