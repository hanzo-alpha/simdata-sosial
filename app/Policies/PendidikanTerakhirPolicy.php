<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PendidikanTerakhir;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PendidikanTerakhirPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_pendidikan::terakhir');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $user->can('view_pendidikan::terakhir');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_pendidikan::terakhir');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $user->can('update_pendidikan::terakhir');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $user->can('delete_pendidikan::terakhir');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_pendidikan::terakhir');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $user->can('force_delete_pendidikan::terakhir');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_pendidikan::terakhir');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $user->can('restore_pendidikan::terakhir');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_pendidikan::terakhir');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }

    public function download(User $user): bool
    {
        return $user->can('download_pendidikan::terakhir');
    }

    public function upload(User $user): bool
    {
        return $user->can('upload_pendidikan::terakhir');
    }

    public function verifyStatus(User $user): bool
    {
        return $user->can('verify_status_pendidikan::terakhir');
    }


    public function verification(User $user): bool
    {
        return $user->can('verification_pendidikan::terakhir');
    }
}
