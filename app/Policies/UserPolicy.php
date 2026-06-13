<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        // Impedir admin de remover o próprio admin status
        if ($ability === 'updateAdmin') {
            return null;
        }
        
        // Para a ação 'block', NÃO retornar true automaticamente
        // Assim o método block() será chamado
        if ($ability === 'block') {
            return null;  // ← DEIXA O MÉTODO block() DECIDIR
        }
        
        if ($user?->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $targetUser): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function createAdmin(User $user): bool
    {
        // Only existing admins can create new admins
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $targetUser): bool
    {
        return $user->isAdmin();
    }

    public function updateAdmin(User $user, User $targetUser): bool
    {
        // Only update if is admin and not himself
        return $user->isAdmin() && $user->id !== $targetUser->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $targetUser): bool
    {
        return $user->isAdmin() && $user->id !== $targetUser->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, $targetUser): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $targetUser): bool
    {
        return $user->isAdmin() && $user->id !== $targetUser->id;
    }

    public function block(User $user, User $targetUser): bool
    {
        return $user->isAdmin() && $user->id !== $targetUser->id;
    }
}
