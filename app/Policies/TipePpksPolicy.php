<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TipePpks;
use Illuminate\Auth\Access\HandlesAuthorization;

class TipePpksPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_tipe_ppks');
    }

    public function view(AuthUser $authUser, TipePpks $tipePpks): bool
    {
        return $authUser->can('view_tipe_ppks');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_tipe_ppks');
    }

    public function update(AuthUser $authUser, TipePpks $tipePpks): bool
    {
        return $authUser->can('update_tipe_ppks');
    }

    public function delete(AuthUser $authUser, TipePpks $tipePpks): bool
    {
        return $authUser->can('delete_tipe_ppks');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_tipe_ppks');
    }

    public function restore(AuthUser $authUser, TipePpks $tipePpks): bool
    {
        return $authUser->can('restore_tipe_ppks');
    }

    public function forceDelete(AuthUser $authUser, TipePpks $tipePpks): bool
    {
        return $authUser->can('force_delete_tipe_ppks');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_tipe_ppks');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_tipe_ppks');
    }

    public function replicate(AuthUser $authUser, TipePpks $tipePpks): bool
    {
        return $authUser->can('replicate_tipe_ppks');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_tipe_ppks');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_tipe_ppks');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_tipe_ppks');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_tipe_ppks');
    }

    public function verifyStatus(AuthUser $authUser, TipePpks $tipePpks): bool
    {
        return $authUser->can('verify_status_tipe_ppks');
    }

}