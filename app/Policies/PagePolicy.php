<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionsEnum::ManagePages);
    }

    public function view(User $user, Page $page): bool
    {
        return $user->can(PermissionsEnum::ManagePages);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionsEnum::ManagePages);
    }

    public function update(User $user, Page $page): bool
    {
        return $user->can(PermissionsEnum::ManagePages);
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->can(PermissionsEnum::ManagePages);
    }
}
