<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\ContactMessage;
use App\Models\User;

class ContactMessagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionsEnum::ManageContactMessages);
    }

    public function view(User $user, ContactMessage $contactMessage): bool
    {
        return $user->can(PermissionsEnum::ManageContactMessages);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, ContactMessage $contactMessage): bool
    {
        return $user->can(PermissionsEnum::ManageContactMessages);
    }

    public function delete(User $user, ContactMessage $contactMessage): bool
    {
        return $user->can(PermissionsEnum::ManageContactMessages);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(PermissionsEnum::ManageContactMessages);
    }
}
