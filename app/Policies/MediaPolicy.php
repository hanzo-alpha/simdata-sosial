<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Awcodes\Curator\Models\Media;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_media');
    }

    public function view(AuthUser $authUser, Media $media): bool
    {
        return $authUser->can('view_media');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_media');
    }

    public function update(AuthUser $authUser, Media $media): bool
    {
        return $authUser->can('update_media');
    }

    public function delete(AuthUser $authUser, Media $media): bool
    {
        return $authUser->can('delete_media');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_media');
    }

    public function restore(AuthUser $authUser, Media $media): bool
    {
        return $authUser->can('restore_media');
    }

    public function forceDelete(AuthUser $authUser, Media $media): bool
    {
        return $authUser->can('force_delete_media');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_media');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_media');
    }

    public function replicate(AuthUser $authUser, Media $media): bool
    {
        return $authUser->can('replicate_media');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_media');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_media');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_media');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_media');
    }

    public function verifyStatus(AuthUser $authUser, Media $media): bool
    {
        return $authUser->can('verify_status_media');
    }

}