<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\BantuanPkh;
use Illuminate\Auth\Access\HandlesAuthorization;

class BantuanPkhPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_bantuan_pkh');
    }

    public function view(AuthUser $authUser, BantuanPkh $bantuanPkh): bool
    {
        return $authUser->can('view_bantuan_pkh');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_bantuan_pkh');
    }

    public function update(AuthUser $authUser, BantuanPkh $bantuanPkh): bool
    {
        return $authUser->can('update_bantuan_pkh');
    }

    public function delete(AuthUser $authUser, BantuanPkh $bantuanPkh): bool
    {
        return $authUser->can('delete_bantuan_pkh');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_bantuan_pkh');
    }

    public function restore(AuthUser $authUser, BantuanPkh $bantuanPkh): bool
    {
        return $authUser->can('restore_bantuan_pkh');
    }

    public function forceDelete(AuthUser $authUser, BantuanPkh $bantuanPkh): bool
    {
        return $authUser->can('force_delete_bantuan_pkh');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_bantuan_pkh');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_bantuan_pkh');
    }

    public function replicate(AuthUser $authUser, BantuanPkh $bantuanPkh): bool
    {
        return $authUser->can('replicate_bantuan_pkh');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_bantuan_pkh');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_bantuan_pkh');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_bantuan_pkh');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_bantuan_pkh');
    }

    public function verifyStatus(AuthUser $authUser, BantuanPkh $bantuanPkh): bool
    {
        return $authUser->can('verify_status_bantuan_pkh');
    }

}