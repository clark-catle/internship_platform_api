<?php

namespace App\Enum\Internship;

enum InternshipSetupEnum: string
{
    case OnSite = 'on site';
    case Hybrid = 'hybrid';
    case Remote = 'remote';
}
