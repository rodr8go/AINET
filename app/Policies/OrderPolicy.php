<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Before method - admins can do everything
     */
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->isAdmin()) {
            return true;  // Admin has all permissions
        }
        return null;  // Let specific methods decide for others
    }
    
    /**
     * Determine whether the user can view any models (list all orders)
     * Only admins and employees can see the full order list
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEmployee();
    }
    
    /**
     * Determine whether the user can view a specific order
     */
    public function view(User $user, Order $order): bool
    {
        // Customers can view their own orders
        if ($user->isCustomer() && $user->id === $order->customer_id) {
            return true;
        }
        
        // Employees can view orders (for processing)
        if ($user->isEmployee()) {
            return true;
        }
        
        // Admins can view all orders
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Determine whether the user can create orders (checkout)
     * Only customers can create orders
     */
    public function create(User $user): bool
    {
        return $user->isCustomer();
    }
    
    /**
     * Determine whether the user can update an order
     * Only employees and admins can update order status
     */
    public function update(User $user, Order $order): bool
    {
        // Employees can update orders (change status to closed)
        if ($user->isEmployee()) {
            return true;
        }
        
        // Admins can update any order
        if ($user->isAdmin()) {
            return true;
        }
        
        // Customers cannot update orders after creation
        return false;
    }
    
    /**
     * Determine whether the user can cancel an order
     */
    public function cancel(User $user, Order $order): bool
    {
        // Customers can cancel their own pending orders
        if ($user->isCustomer() && $user->id === $order->customer_id && $order->isPending()) {
            return true;
        }
        
        // Admins can cancel any order
        if ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Determine whether the user can download receipt
     * Only customer who owns the order and admins can download
     */
    public function downloadReceipt(User $user, Order $order): bool
    {
        // Customer can download their own closed order receipt
        if ($user->isCustomer() && $user->id === $order->customer_id && $order->isClosed()) {
            return true;
        }
        
        // Admin can download any receipt
        if ($user->isAdmin()) {
            return true;
        }
        
        // Employees cannot download receipts
        return false;
    }
    
    /**
     * Determine whether the user can delete an order
     * Only admins can delete orders (soft delete)
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }
    
    /**
     * Determine whether the user can restore an order
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }
    
    /**
     * Determine whether the user can permanently delete an order
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }
}