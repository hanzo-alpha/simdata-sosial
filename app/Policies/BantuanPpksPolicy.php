<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\BantuanPpks;
use Illuminate\Auth\Access\HandlesAuthorization;

class BantuanPpksPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_bantuan_ppks');
    }

    public function view(AuthUser $authUser, BantuanPpks $bantuanPpks): bool
    {
        return $authUser->can('view_bantuan_ppks');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_bantuan_ppks');
    }

    public function update(AuthUser $authUser, BantuanPpks $bantuanPpks): bool
    {
        return $authUser->can('update_bantuan_ppks');
    }

    public function delete(AuthUser $authUser, BantuanPpks $bantuanPpks): bool
    {
        return $authUser->can('delete_bantuan_ppks');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_bantuan_ppks');
    }

    public function restore(AuthUser $authUser, BantuanPpks $bantuanPpks): bool
    {
        return $authUser->can('restore_bantuan_ppks');
    }

    public function forceDelete(AuthUser $authUser, BantuanPpks $bantuanPpks): bool
    {
        return $authUser->can('force_delete_bantuan_ppks');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_bantuan_ppks');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_bantuan_ppks');
    }

    public function replicate(AuthUser $authUser, BantuanPpks $bantuanPpks): bool
    {
        return $authUser->can('replicate_bantuan_ppks');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_bantuan_ppks');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_bantuan_ppks');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_bantuan_ppks');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_bantuan_ppks');
    }

    public function verifyStatus(AuthUser $authUser, BantuanPpks $bantuanPpks): bool
    {
        return $authUser->can('verify_status_bantuan_ppks');
    }

}