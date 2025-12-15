<?php

namespace App\Policies;

use App\Models\LiveClass;
use App\Models\User;
use App\Models\Pembelian;
use Illuminate\Auth\Access\HandlesAuthorization;

class LiveClassPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any live classes.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the live class.
     */
    public function view(User $user, LiveClass $liveClass)
    {
        // Tutors can view their own live classes
        if ($liveClass->tutor_id === $user->id) {
            return true;
        }

        // Check if user has purchased the batch this live class belongs to
        if ($liveClass->batch_id) {
            return Pembelian::where('user_id', $user->id)
                ->where('paket_id', $liveClass->batch_id)
                ->where('status', 'Sudah Bayar')
                ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can create live classes.
     */
    public function create(User $user)
    {
        return $user->hasRole('tutor');
    }

    /**
     * Determine whether the user can update the live class.
     */
    public function update(User $user, LiveClass $liveClass)
    {
        return $user->hasRole('tutor') && $liveClass->tutor_id === $user->id;
    }

    /**
     * Determine whether the user can delete the live class.
     */
    public function delete(User $user, LiveClass $liveClass)
    {
        return $user->hasRole('tutor') && $liveClass->tutor_id === $user->id;
    }

    /**
     * Determine whether the user can restore the live class.
     */
    public function restore(User $user, LiveClass $liveClass)
    {
        return $user->hasRole('tutor') && $liveClass->tutor_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the live class.
     */
    public function forceDelete(User $user, LiveClass $liveClass)
    {
        return $user->hasRole('admin');
    }
}