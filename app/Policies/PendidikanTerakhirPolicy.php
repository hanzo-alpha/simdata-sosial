<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PendidikanTerakhir;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PendidikanTerakhirPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_pendidikan_terakhir');
    }

    public function view(AuthUser $authUser, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $authUser->can('view_pendidikan_terakhir');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_pendidikan_terakhir');
    }

    public function update(AuthUser $authUser, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $authUser->can('update_pendidikan_terakhir');
    }

    public function delete(AuthUser $authUser, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $authUser->can('delete_pendidikan_terakhir');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_pendidikan_terakhir');
    }

    public function restore(AuthUser $authUser, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $authUser->can('restore_pendidikan_terakhir');
    }

    public function forceDelete(AuthUser $authUser, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $authUser->can('force_delete_pendidikan_terakhir');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_pendidikan_terakhir');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_pendidikan_terakhir');
    }

    public function replicate(AuthUser $authUser, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $authUser->can('replicate_pendidikan_terakhir');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_pendidikan_terakhir');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_pendidikan_terakhir');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_pendidikan_terakhir');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_pendidikan_terakhir');
    }

    public function verifyStatus(AuthUser $authUser, PendidikanTerakhir $pendidikanTerakhir): bool
    {
        return $authUser->can('verify_status_pendidikan_terakhir');
    }

}
