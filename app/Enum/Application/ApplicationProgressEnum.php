<?php

namespace App\Enum\Application;

enum ApplicationProgressEnum: string
{
    case Applied = 'applied';
    case Interview = 'interview';
    case Decision = 'decision';
}
