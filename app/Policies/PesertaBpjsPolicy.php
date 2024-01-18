<?php

namespace App\Policies;

use App\Models\PesertaBpjs;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PesertaBpjsPolicy
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
        return $user->can('view_any_peserta::bpjs');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PesertaBpjs  $pesertaBpjs
     * @return bool
     */
    public function view(User $user, PesertaBpjs $pesertaBpjs): bool
    {
        return $user->can('view_peserta::bpjs');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create_peserta::bpjs');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PesertaBpjs  $pesertaBpjs
     * @return bool
     */
    public function update(User $user, PesertaBpjs $pesertaBpjs): bool
    {
        return $user->can('update_peserta::bpjs');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PesertaBpjs  $pesertaBpjs
     * @return bool
     */
    public function delete(User $user, PesertaBpjs $pesertaBpjs): bool
    {
        return $user->can('delete_peserta::bpjs');
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
     * @param  \App\Models\PesertaBpjs  $pesertaBpjs
     * @return bool
     */
    public function forceDelete(User $user, PesertaBpjs $pesertaBpjs): bool
    {
        return $user->can('force_delete_peserta::bpjs');
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
     * @param  \App\Models\PesertaBpjs  $pesertaBpjs
     * @return bool
     */
    public function restore(User $user, PesertaBpjs $pesertaBpjs): bool
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
     * @param  \App\Models\PesertaBpjs  $pesertaBpjs
     * @return bool
     */
    public function replicate(User $user, PesertaBpjs $pesertaBpjs): bool
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
