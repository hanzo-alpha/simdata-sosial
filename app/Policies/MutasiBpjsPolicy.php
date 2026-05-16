<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\MutasiBpjs;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class MutasiBpjsPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_mutasi_bpjs');
    }

    public function view(AuthUser $authUser, MutasiBpjs $mutasiBpjs): bool
    {
        return $authUser->can('view_mutasi_bpjs');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_mutasi_bpjs');
    }

    public function update(AuthUser $authUser, MutasiBpjs $mutasiBpjs): bool
    {
        return $authUser->can('update_mutasi_bpjs');
    }

    public function delete(AuthUser $authUser, MutasiBpjs $mutasiBpjs): bool
    {
        return $authUser->can('delete_mutasi_bpjs');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_mutasi_bpjs');
    }

    public function restore(AuthUser $authUser, MutasiBpjs $mutasiBpjs): bool
    {
        return $authUser->can('restore_mutasi_bpjs');
    }

    public function forceDelete(AuthUser $authUser, MutasiBpjs $mutasiBpjs): bool
    {
        return $authUser->can('force_delete_mutasi_bpjs');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_mutasi_bpjs');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_mutasi_bpjs');
    }

    public function replicate(AuthUser $authUser, MutasiBpjs $mutasiBpjs): bool
    {
        return $authUser->can('replicate_mutasi_bpjs');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_mutasi_bpjs');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_mutasi_bpjs');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_mutasi_bpjs');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_mutasi_bpjs');
    }

    public function verifyStatus(AuthUser $authUser, MutasiBpjs $mutasiBpjs): bool
    {
        return $authUser->can('verify_status_mutasi_bpjs');
    }

}
