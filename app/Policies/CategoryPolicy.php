<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * WingaX is single-tenant: any authenticated user is the store admin.
     * This before-hook keeps the policy structure ready for future roles
     * while granting full access to all authenticated users today.
     */
    public function before(User $user, string $ability): ?bool
    {
        return true;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Category $category): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Category $category): bool
    {
        return true;
    }

    public function delete(User $user, Category $category): bool
    {
        return true;
    }
}
