<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DetailBantuanPpks;
use Illuminate\Auth\Access\HandlesAuthorization;

class DetailBantuanPpksPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_detail_bantuan_ppks');
    }

    public function view(AuthUser $authUser, DetailBantuanPpks $detailBantuanPpks): bool
    {
        return $authUser->can('view_detail_bantuan_ppks');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_detail_bantuan_ppks');
    }

    public function update(AuthUser $authUser, DetailBantuanPpks $detailBantuanPpks): bool
    {
        return $authUser->can('update_detail_bantuan_ppks');
    }

    public function delete(AuthUser $authUser, DetailBantuanPpks $detailBantuanPpks): bool
    {
        return $authUser->can('delete_detail_bantuan_ppks');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_detail_bantuan_ppks');
    }

    public function restore(AuthUser $authUser, DetailBantuanPpks $detailBantuanPpks): bool
    {
        return $authUser->can('restore_detail_bantuan_ppks');
    }

    public function forceDelete(AuthUser $authUser, DetailBantuanPpks $detailBantuanPpks): bool
    {
        return $authUser->can('force_delete_detail_bantuan_ppks');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_detail_bantuan_ppks');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_detail_bantuan_ppks');
    }

    public function replicate(AuthUser $authUser, DetailBantuanPpks $detailBantuanPpks): bool
    {
        return $authUser->can('replicate_detail_bantuan_ppks');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_detail_bantuan_ppks');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_detail_bantuan_ppks');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_detail_bantuan_ppks');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_detail_bantuan_ppks');
    }

    public function verifyStatus(AuthUser $authUser, DetailBantuanPpks $detailBantuanPpks): bool
    {
        return $authUser->can('verify_status_detail_bantuan_ppks');
    }

}