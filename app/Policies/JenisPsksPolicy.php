<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\JenisPsks;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class JenisPsksPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_jenis_psks');
    }

    public function view(AuthUser $authUser, JenisPsks $jenisPsks): bool
    {
        return $authUser->can('view_jenis_psks');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_jenis_psks');
    }

    public function update(AuthUser $authUser, JenisPsks $jenisPsks): bool
    {
        return $authUser->can('update_jenis_psks');
    }

    public function delete(AuthUser $authUser, JenisPsks $jenisPsks): bool
    {
        return $authUser->can('delete_jenis_psks');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_jenis_psks');
    }

    public function restore(AuthUser $authUser, JenisPsks $jenisPsks): bool
    {
        return $authUser->can('restore_jenis_psks');
    }

    public function forceDelete(AuthUser $authUser, JenisPsks $jenisPsks): bool
    {
        return $authUser->can('force_delete_jenis_psks');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_jenis_psks');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_jenis_psks');
    }

    public function replicate(AuthUser $authUser, JenisPsks $jenisPsks): bool
    {
        return $authUser->can('replicate_jenis_psks');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_jenis_psks');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_jenis_psks');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_jenis_psks');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_jenis_psks');
    }

    public function verifyStatus(AuthUser $authUser, JenisPsks $jenisPsks): bool
    {
        return $authUser->can('verify_status_jenis_psks');
    }

}
