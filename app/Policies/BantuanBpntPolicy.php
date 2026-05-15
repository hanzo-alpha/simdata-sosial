<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\BantuanBpnt;
use Illuminate\Auth\Access\HandlesAuthorization;

class BantuanBpntPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_bantuan_bpnt');
    }

    public function view(AuthUser $authUser, BantuanBpnt $bantuanBpnt): bool
    {
        return $authUser->can('view_bantuan_bpnt');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_bantuan_bpnt');
    }

    public function update(AuthUser $authUser, BantuanBpnt $bantuanBpnt): bool
    {
        return $authUser->can('update_bantuan_bpnt');
    }

    public function delete(AuthUser $authUser, BantuanBpnt $bantuanBpnt): bool
    {
        return $authUser->can('delete_bantuan_bpnt');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_bantuan_bpnt');
    }

    public function restore(AuthUser $authUser, BantuanBpnt $bantuanBpnt): bool
    {
        return $authUser->can('restore_bantuan_bpnt');
    }

    public function forceDelete(AuthUser $authUser, BantuanBpnt $bantuanBpnt): bool
    {
        return $authUser->can('force_delete_bantuan_bpnt');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_bantuan_bpnt');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_bantuan_bpnt');
    }

    public function replicate(AuthUser $authUser, BantuanBpnt $bantuanBpnt): bool
    {
        return $authUser->can('replicate_bantuan_bpnt');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_bantuan_bpnt');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_bantuan_bpnt');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_bantuan_bpnt');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_bantuan_bpnt');
    }

    public function verifyStatus(AuthUser $authUser, BantuanBpnt $bantuanBpnt): bool
    {
        return $authUser->can('verify_status_bantuan_bpnt');
    }

}