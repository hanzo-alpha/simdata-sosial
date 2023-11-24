<?php

namespace App\Policies;

use App\Models\Families;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FamiliesPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Families $families): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Families $families): bool
    {
    }

    public function delete(User $user, Families $families): bool
    {
    }

    public function restore(User $user, Families $families): bool
    {
    }

    public function forceDelete(User $user, Families $families): bool
    {
    }
}
