<?php

namespace App\Policies;

use App\Models\BantuanPkh;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BantuanPkhPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_bantuan::pkh');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BantuanPkh  $bantuanPkh
     * @return bool
     */
    public function view(User $user, BantuanPkh $bantuanPkh): bool
    {
        return $user->can('view_bantuan::pkh');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create_bantuan::pkh');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BantuanPkh  $bantuanPkh
     * @return bool
     */
    public function update(User $user, BantuanPkh $bantuanPkh): bool
    {
        return $user->can('update_bantuan::pkh');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BantuanPkh  $bantuanPkh
     * @return bool
     */
    public function delete(User $user, BantuanPkh $bantuanPkh): bool
    {
        return $user->can('delete_bantuan::pkh');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('{{ DeleteAny }}');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BantuanPkh  $bantuanPkh
     * @return bool
     */
    public function forceDelete(User $user, BantuanPkh $bantuanPkh): bool
    {
        return $user->can('force_delete_bantuan::pkh');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BantuanPkh  $bantuanPkh
     * @return bool
     */
    public function restore(User $user, BantuanPkh $bantuanPkh): bool
    {
        return $user->can('restore_bantuan::pkh');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BantuanPkh  $bantuanPkh
     * @return bool
     */
    public function replicate(User $user, BantuanPkh $bantuanPkh): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function reorder(User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }

}
