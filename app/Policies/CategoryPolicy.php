<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->isAdmin()) {
            return true;
        }
        return null;
    }
    
    public function viewAny(?User $user): bool
    {
        return true;  // Anyone can view categories
    }
    
    public function view(?User $user, Category $category): bool
    {
        return true;  // Anyone can view a category
    }
    
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }
    
    public function update(User $user, Category $category): bool
    {
        return $user->isAdmin();
    }
    
    public function delete(User $user, Category $category): bool
    {
        return $user->isAdmin();
    }
}
