<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PenyaluranBantuanRastra;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PenyaluranBantuanRastraPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_penyaluran_bantuan_rastra');
    }

    public function view(AuthUser $authUser, PenyaluranBantuanRastra $penyaluranBantuanRastra): bool
    {
        return $authUser->can('view_penyaluran_bantuan_rastra');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_penyaluran_bantuan_rastra');
    }

    public function update(AuthUser $authUser, PenyaluranBantuanRastra $penyaluranBantuanRastra): bool
    {
        return $authUser->can('update_penyaluran_bantuan_rastra');
    }

    public function delete(AuthUser $authUser, PenyaluranBantuanRastra $penyaluranBantuanRastra): bool
    {
        return $authUser->can('delete_penyaluran_bantuan_rastra');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_penyaluran_bantuan_rastra');
    }

    public function restore(AuthUser $authUser, PenyaluranBantuanRastra $penyaluranBantuanRastra): bool
    {
        return $authUser->can('restore_penyaluran_bantuan_rastra');
    }

    public function forceDelete(AuthUser $authUser, PenyaluranBantuanRastra $penyaluranBantuanRastra): bool
    {
        return $authUser->can('force_delete_penyaluran_bantuan_rastra');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_penyaluran_bantuan_rastra');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_penyaluran_bantuan_rastra');
    }

    public function replicate(AuthUser $authUser, PenyaluranBantuanRastra $penyaluranBantuanRastra): bool
    {
        return $authUser->can('replicate_penyaluran_bantuan_rastra');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_penyaluran_bantuan_rastra');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_penyaluran_bantuan_rastra');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_penyaluran_bantuan_rastra');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_penyaluran_bantuan_rastra');
    }

    public function verifyStatus(AuthUser $authUser, PenyaluranBantuanRastra $penyaluranBantuanRastra): bool
    {
        return $authUser->can('verify_status_penyaluran_bantuan_rastra');
    }

}
