<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PenggantiRastra;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenggantiRastraPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_pengganti_rastra');
    }

    public function view(AuthUser $authUser, PenggantiRastra $penggantiRastra): bool
    {
        return $authUser->can('view_pengganti_rastra');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_pengganti_rastra');
    }

    public function update(AuthUser $authUser, PenggantiRastra $penggantiRastra): bool
    {
        return $authUser->can('update_pengganti_rastra');
    }

    public function delete(AuthUser $authUser, PenggantiRastra $penggantiRastra): bool
    {
        return $authUser->can('delete_pengganti_rastra');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_pengganti_rastra');
    }

    public function restore(AuthUser $authUser, PenggantiRastra $penggantiRastra): bool
    {
        return $authUser->can('restore_pengganti_rastra');
    }

    public function forceDelete(AuthUser $authUser, PenggantiRastra $penggantiRastra): bool
    {
        return $authUser->can('force_delete_pengganti_rastra');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_pengganti_rastra');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_pengganti_rastra');
    }

    public function replicate(AuthUser $authUser, PenggantiRastra $penggantiRastra): bool
    {
        return $authUser->can('replicate_pengganti_rastra');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_pengganti_rastra');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_pengganti_rastra');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_pengganti_rastra');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_pengganti_rastra');
    }

    public function verifyStatus(AuthUser $authUser, PenggantiRastra $penggantiRastra): bool
    {
        return $authUser->can('verify_status_pengganti_rastra');
    }

}