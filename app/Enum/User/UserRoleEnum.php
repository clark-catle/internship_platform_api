<?php

namespace App\Enum\User;

enum UserRoleEnum: string
{
    case Student = 'student';
    case Company = 'company';
    case Admin = 'admin';
}
