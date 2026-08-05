<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\BlogPost;
use App\Models\User;

class BlogPostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionsEnum::ManageBlog);
    }

    public function view(User $user, BlogPost $blogPost): bool
    {
        return $user->can(PermissionsEnum::ManageBlog);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionsEnum::ManageBlog);
    }

    public function update(User $user, BlogPost $blogPost): bool
    {
        return $user->can(PermissionsEnum::ManageBlog);
    }

    public function delete(User $user, BlogPost $blogPost): bool
    {
        return $user->can(PermissionsEnum::ManageBlog);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(PermissionsEnum::ManageBlog);
    }
}
