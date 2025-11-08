<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PenyaluranBantuanPpks;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenyaluranBantuanPpksPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_penyaluran::bantuan::ppks');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
    {
        return $user->can('view_penyaluran::bantuan::ppks');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_penyaluran::bantuan::ppks');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
    {
        return $user->can('update_penyaluran::bantuan::ppks');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
    {
        return $user->can('delete_penyaluran::bantuan::ppks');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_penyaluran::bantuan::ppks');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
    {
        return $user->can('force_delete_penyaluran::bantuan::ppks');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_penyaluran::bantuan::ppks');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
    {
        return $user->can('restore_penyaluran::bantuan::ppks');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_penyaluran::bantuan::ppks');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
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
