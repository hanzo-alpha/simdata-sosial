<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KriteriaPpks;
use Illuminate\Auth\Access\HandlesAuthorization;

class KriteriaPpksPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_kriteria_ppks');
    }

    public function view(AuthUser $authUser, KriteriaPpks $kriteriaPpks): bool
    {
        return $authUser->can('view_kriteria_ppks');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_kriteria_ppks');
    }

    public function update(AuthUser $authUser, KriteriaPpks $kriteriaPpks): bool
    {
        return $authUser->can('update_kriteria_ppks');
    }

    public function delete(AuthUser $authUser, KriteriaPpks $kriteriaPpks): bool
    {
        return $authUser->can('delete_kriteria_ppks');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_kriteria_ppks');
    }

    public function restore(AuthUser $authUser, KriteriaPpks $kriteriaPpks): bool
    {
        return $authUser->can('restore_kriteria_ppks');
    }

    public function forceDelete(AuthUser $authUser, KriteriaPpks $kriteriaPpks): bool
    {
        return $authUser->can('force_delete_kriteria_ppks');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_kriteria_ppks');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_kriteria_ppks');
    }

    public function replicate(AuthUser $authUser, KriteriaPpks $kriteriaPpks): bool
    {
        return $authUser->can('replicate_kriteria_ppks');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_kriteria_ppks');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_kriteria_ppks');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_kriteria_ppks');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_kriteria_ppks');
    }

    public function verifyStatus(AuthUser $authUser, KriteriaPpks $kriteriaPpks): bool
    {
        return $authUser->can('verify_status_kriteria_ppks');
    }

}