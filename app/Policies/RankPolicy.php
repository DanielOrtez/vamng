<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

final class RankPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Rank');
    }

    public function view(AuthUser $authUser): bool
    {
        return $authUser->can('View:Rank');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Rank');
    }

    public function update(AuthUser $authUser): bool
    {
        return $authUser->can('Update:Rank');
    }

    public function delete(AuthUser $authUser): bool
    {
        return $authUser->can('Delete:Rank');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Rank');
    }

    public function restore(AuthUser $authUser): bool
    {
        return $authUser->can('Restore:Rank');
    }

    public function forceDelete(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDelete:Rank');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Rank');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Rank');
    }

    public function replicate(AuthUser $authUser): bool
    {
        return $authUser->can('Replicate:Rank');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Rank');
    }
}
