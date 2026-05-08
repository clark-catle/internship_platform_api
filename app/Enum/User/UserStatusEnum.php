<?php

namespace App\Enum\User;

enum UserStatusEnum: string
{
    case Active = 'active';
    case Block = 'block';
    case Deleted = 'deleted';
}
