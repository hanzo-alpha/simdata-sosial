<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Croustibat\FilamentJobsMonitor\Models\QueueMonitor;
use Illuminate\Auth\Access\HandlesAuthorization;

class QueueMonitorPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_queue_monitor');
    }

    public function view(AuthUser $authUser, QueueMonitor $queueMonitor): bool
    {
        return $authUser->can('view_queue_monitor');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_queue_monitor');
    }

    public function update(AuthUser $authUser, QueueMonitor $queueMonitor): bool
    {
        return $authUser->can('update_queue_monitor');
    }

    public function delete(AuthUser $authUser, QueueMonitor $queueMonitor): bool
    {
        return $authUser->can('delete_queue_monitor');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete_any_queue_monitor');
    }

    public function restore(AuthUser $authUser, QueueMonitor $queueMonitor): bool
    {
        return $authUser->can('restore_queue_monitor');
    }

    public function forceDelete(AuthUser $authUser, QueueMonitor $queueMonitor): bool
    {
        return $authUser->can('force_delete_queue_monitor');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_queue_monitor');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_queue_monitor');
    }

    public function replicate(AuthUser $authUser, QueueMonitor $queueMonitor): bool
    {
        return $authUser->can('replicate_queue_monitor');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_queue_monitor');
    }

    public function download(AuthUser $authUser): bool
    {
        return $authUser->can('download_queue_monitor');
    }

    public function upload(AuthUser $authUser): bool
    {
        return $authUser->can('upload_queue_monitor');
    }

    public function verification(AuthUser $authUser): bool
    {
        return $authUser->can('verification_queue_monitor');
    }

    public function verifyStatus(AuthUser $authUser, QueueMonitor $queueMonitor): bool
    {
        return $authUser->can('verify_status_queue_monitor');
    }

}