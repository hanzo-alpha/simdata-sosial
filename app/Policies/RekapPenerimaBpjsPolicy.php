<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\RekapPenerimaBpjs;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class RekapPenerimaBpjsPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_rekap_penerima_bpjs');
    }

    public function view(AuthUser $authUser, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
    {
        return $authUser->can('view_rekap_penerima_bpjs');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_rekap_penerima_bpjs');
    }

    public function update(AuthUser $authUser, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
    {
        return $authUser->can('update_rekap_penerima_bpjs');
    }

    public function delete(AuthUser $authUser, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
    {
        return $authUser->can('delete_rekap_penerima_bpjs');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_rekap_penerima_bpjs');
    }

    public function restore(AuthUser $authUser, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
    {
        return $authUser->can('restore_rekap_penerima_bpjs');
    }

    public function forceDelete(AuthUser $authUser, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
    {
        return $authUser->can('force_delete_rekap_penerima_bpjs');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_rekap_penerima_bpjs');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_rekap_penerima_bpjs');
    }

    public function replicate(AuthUser $authUser, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
    {
        return $authUser->can('replicate_rekap_penerima_bpjs');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_rekap_penerima_bpjs');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_rekap_penerima_bpjs');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_rekap_penerima_bpjs');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_rekap_penerima_bpjs');
    }

    public function verifyStatus(AuthUser $authUser, RekapPenerimaBpjs $rekapPenerimaBpjs): bool
    {
        return $authUser->can('verify_status_rekap_penerima_bpjs');
    }

}
