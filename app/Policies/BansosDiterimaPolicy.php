<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\BansosDiterima;
use Illuminate\Auth\Access\HandlesAuthorization;

class BansosDiterimaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_bansos_diterima');
    }

    public function view(AuthUser $authUser, BansosDiterima $bansosDiterima): bool
    {
        return $authUser->can('view_bansos_diterima');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_bansos_diterima');
    }

    public function update(AuthUser $authUser, BansosDiterima $bansosDiterima): bool
    {
        return $authUser->can('update_bansos_diterima');
    }

    public function delete(AuthUser $authUser, BansosDiterima $bansosDiterima): bool
    {
        return $authUser->can('delete_bansos_diterima');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_bansos_diterima');
    }

    public function restore(AuthUser $authUser, BansosDiterima $bansosDiterima): bool
    {
        return $authUser->can('restore_bansos_diterima');
    }

    public function forceDelete(AuthUser $authUser, BansosDiterima $bansosDiterima): bool
    {
        return $authUser->can('force_delete_bansos_diterima');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_bansos_diterima');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_bansos_diterima');
    }

    public function replicate(AuthUser $authUser, BansosDiterima $bansosDiterima): bool
    {
        return $authUser->can('replicate_bansos_diterima');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_bansos_diterima');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_bansos_diterima');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_bansos_diterima');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_bansos_diterima');
    }

    public function verifyStatus(AuthUser $authUser, BansosDiterima $bansosDiterima): bool
    {
        return $authUser->can('verify_status_bansos_diterima');
    }

}