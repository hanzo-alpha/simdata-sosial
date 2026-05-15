<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PenyaluranBantuanPpks;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PenyaluranBantuanPpksPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_penyaluran_bantuan_ppks');
    }

    public function view(AuthUser $authUser, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
    {
        return $authUser->can('view_penyaluran_bantuan_ppks');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_penyaluran_bantuan_ppks');
    }

    public function update(AuthUser $authUser, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
    {
        return $authUser->can('update_penyaluran_bantuan_ppks');
    }

    public function delete(AuthUser $authUser, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
    {
        return $authUser->can('delete_penyaluran_bantuan_ppks');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_penyaluran_bantuan_ppks');
    }

    public function restore(AuthUser $authUser, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
    {
        return $authUser->can('restore_penyaluran_bantuan_ppks');
    }

    public function forceDelete(AuthUser $authUser, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
    {
        return $authUser->can('force_delete_penyaluran_bantuan_ppks');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_penyaluran_bantuan_ppks');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_penyaluran_bantuan_ppks');
    }

    public function replicate(AuthUser $authUser, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
    {
        return $authUser->can('replicate_penyaluran_bantuan_ppks');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_penyaluran_bantuan_ppks');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_penyaluran_bantuan_ppks');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_penyaluran_bantuan_ppks');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_penyaluran_bantuan_ppks');
    }

    public function verifyStatus(AuthUser $authUser, PenyaluranBantuanPpks $penyaluranBantuanPpks): bool
    {
        return $authUser->can('verify_status_penyaluran_bantuan_ppks');
    }

}
