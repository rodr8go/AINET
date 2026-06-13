<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    //CHECK IF ADMIN BEFORE
    public function before(?User $user, string $ability): bool|null
    {
        if ($ability == 'viewMy') {
            return null;
        }
        if ($user?->admin) {
            return true;
        }
    
        return null;
    }

    //EMPLOYEES CAN VIEW CUSTOMER LIST
    public function viewAny(User $user): bool
    {
        return $user->isEmployee() || $user->isAdmin();
    }

    //CUSTOMERS CAN VIEW THEMSELVES
    public function view(User $user, Customer $customer): bool
    {
        return $user->id === $customer->id;
    }

    //ADMINS(ONLY) CAN CREATE CUSTOMERS
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    //CUSTOMERS CAN UPDATE THEMSELVES
    public function update(User $user, Customer $customer): bool
    {
        return $user->id === $customer->id;
    }

    //ADMINS(ONLY) CAN DELETE CUSTOMERS
    public function delete(User $user, Customer $customer): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Customer $customer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Customer $customer): bool
    {
        return false;
    }
}
