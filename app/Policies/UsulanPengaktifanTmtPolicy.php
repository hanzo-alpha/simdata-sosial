<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UsulanPengaktifanTmt;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsulanPengaktifanTmtPolicy
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
        return $user->can('view_any_usulan::pengaktifan::tmt');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UsulanPengaktifanTmt  $usulanPengaktifanTmt
     * @return bool
     */
    public function view(User $user, UsulanPengaktifanTmt $usulanPengaktifanTmt): bool
    {
        return $user->can('view_usulan::pengaktifan::tmt');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create_usulan::pengaktifan::tmt');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UsulanPengaktifanTmt  $usulanPengaktifanTmt
     * @return bool
     */
    public function update(User $user, UsulanPengaktifanTmt $usulanPengaktifanTmt): bool
    {
        return $user->can('update_usulan::pengaktifan::tmt');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UsulanPengaktifanTmt  $usulanPengaktifanTmt
     * @return bool
     */
    public function delete(User $user, UsulanPengaktifanTmt $usulanPengaktifanTmt): bool
    {
        return $user->can('delete_usulan::pengaktifan::tmt');
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
     * @param  \App\Models\UsulanPengaktifanTmt  $usulanPengaktifanTmt
     * @return bool
     */
    public function forceDelete(User $user, UsulanPengaktifanTmt $usulanPengaktifanTmt): bool
    {
        return $user->can('force_delete_usulan::pengaktifan::tmt');
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
     * @param  \App\Models\UsulanPengaktifanTmt  $usulanPengaktifanTmt
     * @return bool
     */
    public function restore(User $user, UsulanPengaktifanTmt $usulanPengaktifanTmt): bool
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
     * @param  \App\Models\UsulanPengaktifanTmt  $usulanPengaktifanTmt
     * @return bool
     */
    public function replicate(User $user, UsulanPengaktifanTmt $usulanPengaktifanTmt): bool
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
