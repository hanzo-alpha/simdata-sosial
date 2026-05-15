<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\BeritaAcara;
use Illuminate\Auth\Access\HandlesAuthorization;

class BeritaAcaraPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_berita_acara');
    }

    public function view(AuthUser $authUser, BeritaAcara $beritaAcara): bool
    {
        return $authUser->can('view_berita_acara');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_berita_acara');
    }

    public function update(AuthUser $authUser, BeritaAcara $beritaAcara): bool
    {
        return $authUser->can('update_berita_acara');
    }

    public function delete(AuthUser $authUser, BeritaAcara $beritaAcara): bool
    {
        return $authUser->can('delete_berita_acara');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_berita_acara');
    }

    public function restore(AuthUser $authUser, BeritaAcara $beritaAcara): bool
    {
        return $authUser->can('restore_berita_acara');
    }

    public function forceDelete(AuthUser $authUser, BeritaAcara $beritaAcara): bool
    {
        return $authUser->can('force_delete_berita_acara');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_berita_acara');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_berita_acara');
    }

    public function replicate(AuthUser $authUser, BeritaAcara $beritaAcara): bool
    {
        return $authUser->can('replicate_berita_acara');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_berita_acara');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_berita_acara');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_berita_acara');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_berita_acara');
    }

    public function verifyStatus(AuthUser $authUser, BeritaAcara $beritaAcara): bool
    {
        return $authUser->can('verify_status_berita_acara');
    }

}