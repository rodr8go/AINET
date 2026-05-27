<?php

namespace App\Policies;

use App\Models\Color;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ColorPolicy
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
        return true;  // Anyone can view colors
    }
    
    public function view(?User $user, Color $color): bool
    {
        return true;
    }
    
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }
    
    public function update(User $user, Color $color): bool
    {
        return $user->isAdmin();
    }
    
    public function delete(User $user, Color $color): bool
    {
        return $user->isAdmin();
    }
}
