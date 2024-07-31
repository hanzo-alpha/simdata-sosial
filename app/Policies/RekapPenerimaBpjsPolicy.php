<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RekapPenerimaBpjs;
use Illuminate\Auth\Access\HandlesAuthorization;

class RekapPenerimaBpjsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_rekap::penerima::bpjs');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
    {
        return $user->can('view_rekap::penerima::bpjs');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_rekap::penerima::bpjs');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
    {
        return $user->can('update_rekap::penerima::bpjs');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
    {
        return $user->can('delete_rekap::penerima::bpjs');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_rekap::penerima::bpjs');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
    {
        return $user->can('force_delete_rekap::penerima::bpjs');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_rekap::penerima::bpjs');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
    {
        return $user->can('restore_rekap::penerima::bpjs');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_rekap::penerima::bpjs');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
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
        return $user->can('download_rekap::penerima::bpjs');
    }

    public function upload(User $user): bool
    {
        return $user->can('upload_rekap::penerima::bpjs');
    }

    public function verifyStatus(User $user): bool
    {
        return $user->can('verify_status_rekap::penerima::bpjs');
    }


    public function verification(User $user): bool
    {
        return $user->can('verification_rekap::penerima::bpjs');
    }
}
