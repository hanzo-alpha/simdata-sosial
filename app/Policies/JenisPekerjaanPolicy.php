<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\JenisPekerjaan;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class JenisPekerjaanPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_jenis_pekerjaan');
    }

    public function view(AuthUser $authUser, JenisPekerjaan $jenisPekerjaan): bool
    {
        return $authUser->can('view_jenis_pekerjaan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_jenis_pekerjaan');
    }

    public function update(AuthUser $authUser, JenisPekerjaan $jenisPekerjaan): bool
    {
        return $authUser->can('update_jenis_pekerjaan');
    }

    public function delete(AuthUser $authUser, JenisPekerjaan $jenisPekerjaan): bool
    {
        return $authUser->can('delete_jenis_pekerjaan');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_jenis_pekerjaan');
    }

    public function restore(AuthUser $authUser, JenisPekerjaan $jenisPekerjaan): bool
    {
        return $authUser->can('restore_jenis_pekerjaan');
    }

    public function forceDelete(AuthUser $authUser, JenisPekerjaan $jenisPekerjaan): bool
    {
        return $authUser->can('force_delete_jenis_pekerjaan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_jenis_pekerjaan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_jenis_pekerjaan');
    }

    public function replicate(AuthUser $authUser, JenisPekerjaan $jenisPekerjaan): bool
    {
        return $authUser->can('replicate_jenis_pekerjaan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_jenis_pekerjaan');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_jenis_pekerjaan');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_jenis_pekerjaan');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_jenis_pekerjaan');
    }

    public function verifyStatus(AuthUser $authUser, JenisPekerjaan $jenisPekerjaan): bool
    {
        return $authUser->can('verify_status_jenis_pekerjaan');
    }

}
