<?php

namespace App\Policies;

use App\Models\LeaveApprovalRule;
use Chiiya\FilamentAccessControl\Models\FilamentUser as User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeaveApprovalRulePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['super-admin']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LeaveApprovalRule $LeaveApprovalRule)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LeaveApprovalRule $LeaveApprovalRule)
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LeaveApprovalRule $LeaveApprovalRule)
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LeaveApprovalRule $LeaveApprovalRule)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LeaveApprovalRule $LeaveApprovalRule)
    {
        //
    }
}