<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\SiteModule;
use App\Models\User;

class SiteModulePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionsEnum::ManageModules);
    }

    public function view(User $user, SiteModule $siteModule): bool
    {
        return $user->can(PermissionsEnum::ManageModules);
    }

    public function update(User $user, SiteModule $siteModule): bool
    {
        return $user->can(PermissionsEnum::ManageModules);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function delete(User $user, SiteModule $siteModule): bool
    {
        return false;
    }
}
