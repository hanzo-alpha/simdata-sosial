<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\HubunganKeluarga;
use Illuminate\Auth\Access\HandlesAuthorization;

class HubunganKeluargaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_hubungan_keluarga');
    }

    public function view(AuthUser $authUser, HubunganKeluarga $hubunganKeluarga): bool
    {
        return $authUser->can('view_hubungan_keluarga');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_hubungan_keluarga');
    }

    public function update(AuthUser $authUser, HubunganKeluarga $hubunganKeluarga): bool
    {
        return $authUser->can('update_hubungan_keluarga');
    }

    public function delete(AuthUser $authUser, HubunganKeluarga $hubunganKeluarga): bool
    {
        return $authUser->can('delete_hubungan_keluarga');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_hubungan_keluarga');
    }

    public function restore(AuthUser $authUser, HubunganKeluarga $hubunganKeluarga): bool
    {
        return $authUser->can('restore_hubungan_keluarga');
    }

    public function forceDelete(AuthUser $authUser, HubunganKeluarga $hubunganKeluarga): bool
    {
        return $authUser->can('force_delete_hubungan_keluarga');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_hubungan_keluarga');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_hubungan_keluarga');
    }

    public function replicate(AuthUser $authUser, HubunganKeluarga $hubunganKeluarga): bool
    {
        return $authUser->can('replicate_hubungan_keluarga');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_hubungan_keluarga');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_hubungan_keluarga');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_hubungan_keluarga');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_hubungan_keluarga');
    }

    public function verifyStatus(AuthUser $authUser, HubunganKeluarga $hubunganKeluarga): bool
    {
        return $authUser->can('verify_status_hubungan_keluarga');
    }

}