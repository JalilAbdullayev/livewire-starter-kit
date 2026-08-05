<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
    case User = 'user';
}
