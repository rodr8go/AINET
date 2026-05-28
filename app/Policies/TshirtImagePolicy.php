<?php

namespace App\Policies;

use App\Models\TshirtImage;
use App\Models\User;

class TshirtImagePolicy
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
     * Anyone (including guests) can view catalog images
     */
    public function viewAny(?User $user): bool
    {
        return true;  // Everyone can see the catalog
    }
    
    /**
     * Anyone can view a specific image (if it's catalog)
     * Custom images have additional restrictions in the view method
     */
    public function view(?User $user, TshirtImage $tshirtImage): bool
    {
        // Catalog images: anyone can view
        if ($tshirtImage->isCatalogImage()) {
            return true;
        }
        
        // Custom images: only owner, employees, or admins
        if ($user && $tshirtImage->isCustomImage()) {
            return $user->id === $tshirtImage->customer_id 
                || $user->isEmployee() 
                || $user->isAdmin();
        }
        
        return false;
    }
    
    /**
     * Who can upload catalog images? Only admins.
     */
    public function createCatalog(User $user): bool
    {
        return $user->isAdmin();
    }
    
    /**
     * Who can upload custom images? Only customers.
     */
    public function createCustom(User $user): bool
    {
        return $user->isCustomer();
    }
    
    /**
     * Generic create - determines which type based on context
     */
    public function create(User $user): bool
    {
        // This is a fallback - better to use createCatalog/createCustom
        return $user->isAdmin() || $user->isCustomer();
    }
    
    /**
     * Who can update an image?
     */
    public function update(User $user, TshirtImage $tshirtImage): bool
    {
        // Catalog images: only admins
        if ($tshirtImage->isCatalogImage()) {
            return $user->isAdmin();
        }
        
        // Custom images: only owner or admin
        return $user->id === $tshirtImage->customer_id || $user->isAdmin();
    }
    
    /**
     * Who can delete an image?
     */
    public function delete(User $user, TshirtImage $tshirtImage): bool
    {
        // Catalog images: only admins
        if ($tshirtImage->isCatalogImage()) {
            return $user->isAdmin();
        }
        
        // Custom images: only owner or admin
        return $user->id === $tshirtImage->customer_id || $user->isAdmin();
    }
    
    /**
     * Who can restore a soft-deleted image?
     */
    public function restore(User $user, TshirtImage $tshirtImage): bool
    {
        return $user->isAdmin();
    }
    
    /**
     * Who can force delete an image?
     */
    public function forceDelete(User $user, TshirtImage $tshirtImage): bool
    {
        return $user->isAdmin();
    }
}