<?php

namespace App\Enums;

enum PermissionsEnum: string
{
    case AccessAdminPanel = 'access_admin_panel';
    case ManageUsers = 'manage_users';
    case ManageRoles = 'manage_roles';
    case ManageModules = 'manage_modules';
    case ManagePages = 'manage_pages';
    case ManageBlog = 'manage_blog';
    case ManageFaqs = 'manage_faqs';
    case ManageContactMessages = 'manage_contact_messages';
    case ManageServiceCards = 'manage_service_cards';
}
