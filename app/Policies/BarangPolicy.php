<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Barang;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class BarangPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_barang');
    }

    public function view(AuthUser $authUser, Barang $barang): bool
    {
        return $authUser->can('view_barang');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_barang');
    }

    public function update(AuthUser $authUser, Barang $barang): bool
    {
        return $authUser->can('update_barang');
    }

    public function delete(AuthUser $authUser, Barang $barang): bool
    {
        return $authUser->can('delete_barang');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_barang');
    }

    public function restore(AuthUser $authUser, Barang $barang): bool
    {
        return $authUser->can('restore_barang');
    }

    public function forceDelete(AuthUser $authUser, Barang $barang): bool
    {
        return $authUser->can('force_delete_barang');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_barang');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_barang');
    }

    public function replicate(AuthUser $authUser, Barang $barang): bool
    {
        return $authUser->can('replicate_barang');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_barang');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_barang');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_barang');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_barang');
    }

    public function verifyStatus(AuthUser $authUser, Barang $barang): bool
    {
        return $authUser->can('verify_status_barang');
    }

}
