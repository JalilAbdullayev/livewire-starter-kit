<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\FaqItem;
use App\Models\User;

class FaqItemPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionsEnum::ManageFaqs);
    }

    public function view(User $user, FaqItem $faqItem): bool
    {
        return $user->can(PermissionsEnum::ManageFaqs);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionsEnum::ManageFaqs);
    }

    public function update(User $user, FaqItem $faqItem): bool
    {
        return $user->can(PermissionsEnum::ManageFaqs);
    }

    public function delete(User $user, FaqItem $faqItem): bool
    {
        return $user->can(PermissionsEnum::ManageFaqs);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(PermissionsEnum::ManageFaqs);
    }
}
