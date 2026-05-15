<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Penandatangan;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PenandatanganPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_penandatangan');
    }

    public function view(AuthUser $authUser, Penandatangan $penandatangan): bool
    {
        return $authUser->can('view_penandatangan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_penandatangan');
    }

    public function update(AuthUser $authUser, Penandatangan $penandatangan): bool
    {
        return $authUser->can('update_penandatangan');
    }

    public function delete(AuthUser $authUser, Penandatangan $penandatangan): bool
    {
        return $authUser->can('delete_penandatangan');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_penandatangan');
    }

    public function restore(AuthUser $authUser, Penandatangan $penandatangan): bool
    {
        return $authUser->can('restore_penandatangan');
    }

    public function forceDelete(AuthUser $authUser, Penandatangan $penandatangan): bool
    {
        return $authUser->can('force_delete_penandatangan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_penandatangan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_penandatangan');
    }

    public function replicate(AuthUser $authUser, Penandatangan $penandatangan): bool
    {
        return $authUser->can('replicate_penandatangan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_penandatangan');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_penandatangan');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_penandatangan');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_penandatangan');
    }

    public function verifyStatus(AuthUser $authUser, Penandatangan $penandatangan): bool
    {
        return $authUser->can('verify_status_penandatangan');
    }

}
