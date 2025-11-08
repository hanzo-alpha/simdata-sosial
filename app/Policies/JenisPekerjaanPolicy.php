<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\JenisPekerjaan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JenisPekerjaanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_jenis::pekerjaan');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, JenisPekerjaan $jenisPekerjaan): bool
    {
        return $user->can('view_jenis::pekerjaan');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_jenis::pekerjaan');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, JenisPekerjaan $jenisPekerjaan): bool
    {
        return $user->can('update_jenis::pekerjaan');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, JenisPekerjaan $jenisPekerjaan): bool
    {
        return $user->can('delete_jenis::pekerjaan');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_jenis::pekerjaan');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, JenisPekerjaan $jenisPekerjaan): bool
    {
        return $user->can('force_delete_jenis::pekerjaan');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_jenis::pekerjaan');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, JenisPekerjaan $jenisPekerjaan): bool
    {
        return $user->can('restore_jenis::pekerjaan');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_jenis::pekerjaan');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, JenisPekerjaan $jenisPekerjaan): bool
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
}
