<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PesertaBpjs;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PesertaBpjsPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_peserta_bpjs');
    }

    public function view(AuthUser $authUser, PesertaBpjs $pesertaBpjs): bool
    {
        return $authUser->can('view_peserta_bpjs');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_peserta_bpjs');
    }

    public function update(AuthUser $authUser, PesertaBpjs $pesertaBpjs): bool
    {
        return $authUser->can('update_peserta_bpjs');
    }

    public function delete(AuthUser $authUser, PesertaBpjs $pesertaBpjs): bool
    {
        return $authUser->can('delete_peserta_bpjs');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_peserta_bpjs');
    }

    public function restore(AuthUser $authUser, PesertaBpjs $pesertaBpjs): bool
    {
        return $authUser->can('restore_peserta_bpjs');
    }

    public function forceDelete(AuthUser $authUser, PesertaBpjs $pesertaBpjs): bool
    {
        return $authUser->can('force_delete_peserta_bpjs');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_peserta_bpjs');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_peserta_bpjs');
    }

    public function replicate(AuthUser $authUser, PesertaBpjs $pesertaBpjs): bool
    {
        return $authUser->can('replicate_peserta_bpjs');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_peserta_bpjs');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_peserta_bpjs');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_peserta_bpjs');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_peserta_bpjs');
    }

    public function verifyStatus(AuthUser $authUser, PesertaBpjs $pesertaBpjs): bool
    {
        return $authUser->can('verify_status_peserta_bpjs');
    }

}
