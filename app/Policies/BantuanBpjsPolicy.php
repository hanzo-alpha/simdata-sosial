<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\BantuanBpjs;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class BantuanBpjsPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_bantuan_bpjs');
    }

    public function view(AuthUser $authUser, BantuanBpjs $bantuanBpjs): bool
    {
        return $authUser->can('view_bantuan_bpjs');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_bantuan_bpjs');
    }

    public function update(AuthUser $authUser, BantuanBpjs $bantuanBpjs): bool
    {
        return $authUser->can('update_bantuan_bpjs');
    }

    public function delete(AuthUser $authUser, BantuanBpjs $bantuanBpjs): bool
    {
        return $authUser->can('delete_bantuan_bpjs');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_bantuan_bpjs');
    }

    public function restore(AuthUser $authUser, BantuanBpjs $bantuanBpjs): bool
    {
        return $authUser->can('restore_bantuan_bpjs');
    }

    public function forceDelete(AuthUser $authUser, BantuanBpjs $bantuanBpjs): bool
    {
        return $authUser->can('force_delete_bantuan_bpjs');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_bantuan_bpjs');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_bantuan_bpjs');
    }

    public function replicate(AuthUser $authUser, BantuanBpjs $bantuanBpjs): bool
    {
        return $authUser->can('replicate_bantuan_bpjs');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_bantuan_bpjs');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_bantuan_bpjs');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_bantuan_bpjs');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_bantuan_bpjs');
    }

    public function verifyStatus(AuthUser $authUser, BantuanBpjs $bantuanBpjs): bool
    {
        return $authUser->can('verify_status_bantuan_bpjs');
    }

}
