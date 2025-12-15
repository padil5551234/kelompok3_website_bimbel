<?php

namespace App\Policies;

use App\Models\Material;
use App\Models\User;
use App\Models\Pembelian;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any materials.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the material.
     */
    public function view(User $user, Material $material)
    {
        // Tutors can view their own materials
        if ($material->tutor_id === $user->id) {
            return true;
        }

        // Public materials can be viewed by anyone
        if ($material->is_public) {
            return true;
        }

        // Check if user has purchased the batch this material belongs to
        if ($material->batch_id) {
            return Pembelian::where('user_id', $user->id)
                ->where('paket_id', $material->batch_id)
                ->where('status', 'Sudah Bayar')
                ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can create materials.
     */
    public function create(User $user)
    {
        return $user->hasRole('tutor');
    }

    /**
     * Determine whether the user can update the material.
     */
    public function update(User $user, Material $material)
    {
        return $user->hasRole('tutor') && $material->tutor_id === $user->id;
    }

    /**
     * Determine whether the user can delete the material.
     */
    public function delete(User $user, Material $material)
    {
        return $user->hasRole('tutor') && $material->tutor_id === $user->id;
    }

    /**
     * Determine whether the user can restore the material.
     */
    public function restore(User $user, Material $material)
    {
        return $user->hasRole('tutor') && $material->tutor_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the material.
     */
    public function forceDelete(User $user, Material $material)
    {
        return $user->hasRole('admin');
    }
}