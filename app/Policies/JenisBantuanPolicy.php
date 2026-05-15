<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\JenisBantuan;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class JenisBantuanPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_jenis_bantuan');
    }

    public function view(AuthUser $authUser, JenisBantuan $jenisBantuan): bool
    {
        return $authUser->can('view_jenis_bantuan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_jenis_bantuan');
    }

    public function update(AuthUser $authUser, JenisBantuan $jenisBantuan): bool
    {
        return $authUser->can('update_jenis_bantuan');
    }

    public function delete(AuthUser $authUser, JenisBantuan $jenisBantuan): bool
    {
        return $authUser->can('delete_jenis_bantuan');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_jenis_bantuan');
    }

    public function restore(AuthUser $authUser, JenisBantuan $jenisBantuan): bool
    {
        return $authUser->can('restore_jenis_bantuan');
    }

    public function forceDelete(AuthUser $authUser, JenisBantuan $jenisBantuan): bool
    {
        return $authUser->can('force_delete_jenis_bantuan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_jenis_bantuan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_jenis_bantuan');
    }

    public function replicate(AuthUser $authUser, JenisBantuan $jenisBantuan): bool
    {
        return $authUser->can('replicate_jenis_bantuan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_jenis_bantuan');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_jenis_bantuan');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_jenis_bantuan');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_jenis_bantuan');
    }

    public function verifyStatus(AuthUser $authUser, JenisBantuan $jenisBantuan): bool
    {
        return $authUser->can('verify_status_jenis_bantuan');
    }

}
