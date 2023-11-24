<?php

namespace App\Policies;

use App\Models\BantuanPkhBpnt;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BantuanPkhBpntPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
//        return $user->can('view_any_bantuan_pkh_bpnt');
        return true;
    }

    public function view(User $user, BantuanPkhBpnt $bantuanPkhBpnt): bool
    {
//        return $user->can('view_bantuan_pkh_bpnt');
        return true;
    }

    public function create(User $user): bool
    {
//        return $user->can('create_bantuan_pkh_bpnt');
        return true;
    }

    public function update(User $user, BantuanPkhBpnt $bantuanPkhBpnt): bool
    {
//        return $user->can('update_bantuan_pkh_bpnt');
        return true;
    }

    public function delete(User $user, BantuanPkhBpnt $bantuanPkhBpnt): bool
    {
//        return $user->can('delete_bantuan_pkh_bpnt');
        return true;
    }

    public function restore(User $user, BantuanPkhBpnt $bantuanPkhBpnt): bool
    {
//        return $user->can('restore_bantuan_pkh_bpnt');
        return true;
    }

    public function forceDelete(User $user, BantuanPkhBpnt $bantuanPkhBpnt): bool
    {
//        return $user->can('{{ ForceDelete }}');
        return true;
    }
}
