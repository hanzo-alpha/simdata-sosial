<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\BantuanRastra;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class BantuanRastraPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_bantuan_rastra');
    }

    public function view(AuthUser $authUser, BantuanRastra $bantuanRastra): bool
    {
        return $authUser->can('view_bantuan_rastra');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_bantuan_rastra');
    }

    public function update(AuthUser $authUser, BantuanRastra $bantuanRastra): bool
    {
        return $authUser->can('update_bantuan_rastra');
    }

    public function delete(AuthUser $authUser, BantuanRastra $bantuanRastra): bool
    {
        return $authUser->can('delete_bantuan_rastra');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_bantuan_rastra');
    }

    public function restore(AuthUser $authUser, BantuanRastra $bantuanRastra): bool
    {
        return $authUser->can('restore_bantuan_rastra');
    }

    public function forceDelete(AuthUser $authUser, BantuanRastra $bantuanRastra): bool
    {
        return $authUser->can('force_delete_bantuan_rastra');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_bantuan_rastra');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_bantuan_rastra');
    }

    public function replicate(AuthUser $authUser, BantuanRastra $bantuanRastra): bool
    {
        return $authUser->can('replicate_bantuan_rastra');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_bantuan_rastra');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_bantuan_rastra');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_bantuan_rastra');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_bantuan_rastra');
    }

    public function verifyStatus(AuthUser $authUser, BantuanRastra $bantuanRastra): bool
    {
        return $authUser->can('verify_status_bantuan_rastra');
    }

}
