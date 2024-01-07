<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BantuanPpks;
use Illuminate\Auth\Access\HandlesAuthorization;

class BantuanPpksPolicy
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
        return $user->can('view_any_bantuan::ppks');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BantuanPpks  $bantuanPpks
     * @return bool
     */
    public function view(User $user, BantuanPpks $bantuanPpks): bool
    {
        return $user->can('view_bantuan::ppks');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create_bantuan::ppks');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BantuanPpks  $bantuanPpks
     * @return bool
     */
    public function update(User $user, BantuanPpks $bantuanPpks): bool
    {
        return $user->can('update_bantuan::ppks');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BantuanPpks  $bantuanPpks
     * @return bool
     */
    public function delete(User $user, BantuanPpks $bantuanPpks): bool
    {
        return $user->can('delete_bantuan::ppks');
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
     * @param  \App\Models\BantuanPpks  $bantuanPpks
     * @return bool
     */
    public function forceDelete(User $user, BantuanPpks $bantuanPpks): bool
    {
        return $user->can('force_delete_bantuan::ppks');
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
     * @param  \App\Models\BantuanPpks  $bantuanPpks
     * @return bool
     */
    public function restore(User $user, BantuanPpks $bantuanPpks): bool
    {
        return $user->can('{{ Restore }}');
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
     * @param  \App\Models\BantuanPpks  $bantuanPpks
     * @return bool
     */
    public function replicate(User $user, BantuanPpks $bantuanPpks): bool
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
