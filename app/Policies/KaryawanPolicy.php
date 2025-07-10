<?php

namespace App\Policies;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KaryawanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Karyawan $karyawan): bool
    {
        return $user->role === 'admin' || $user->role === 'manager' || $user->id === $karyawan->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Karyawan $karyawan): bool
    {
        return $user->role === 'admin' || $user->role === 'manager' || $user->id === $karyawan->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Karyawan $karyawan): bool
    {
        return $user->role === 'admin' || $user->role === 'manager' || $user->id === $karyawan->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Karyawan $karyawan): bool
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Karyawan $karyawan): bool
    {
        return $user->role === 'admin';
    }
}
