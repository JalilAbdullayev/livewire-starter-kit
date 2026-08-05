<?php

namespace App\Enums;

enum PermissionsEnum: string
{
    case AccessAdminPanel = 'access_admin_panel';
    case ManageUsers = 'manage_users';
    case ManageRoles = 'manage_roles';
}
