<?php

namespace App\Policies;

use App\Models\Storefront;
use App\Models\StorefrontComponent;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StorefrontComponentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StorefrontComponent $storefrontComponent): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Storefront $storefront): Response
    {
        return $user->id === $storefront->user_id
            ? Response::allow()
            : Response::deny('You do not own this storefront.', user, 'storefront', $storefront);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StorefrontComponent $storefrontComponent): bool
    {
        return $user->id === $storefrontComponent->storefront->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StorefrontComponent $storefrontComponent): bool
    {
        return $user->id === $storefrontComponent->storefront->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StorefrontComponent $storefrontComponent): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StorefrontComponent $storefrontComponent): bool
    {
        return false;
    }
}
