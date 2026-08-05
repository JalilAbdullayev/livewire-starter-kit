<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\ServiceCard;
use App\Models\User;

class ServiceCardPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionsEnum::ManageServiceCards);
    }

    public function view(User $user, ServiceCard $serviceCard): bool
    {
        return $user->can(PermissionsEnum::ManageServiceCards);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionsEnum::ManageServiceCards);
    }

    public function update(User $user, ServiceCard $serviceCard): bool
    {
        return $user->can(PermissionsEnum::ManageServiceCards);
    }

    public function delete(User $user, ServiceCard $serviceCard): bool
    {
        return $user->can(PermissionsEnum::ManageServiceCards);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(PermissionsEnum::ManageServiceCards);
    }
}
