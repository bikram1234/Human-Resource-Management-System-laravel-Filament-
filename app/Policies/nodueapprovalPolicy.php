<?php

namespace App\Policies;

use Chiiya\FilamentAccessControl\Models\FilamentUser as User;
use App\Models\nodueapproval;
class nodueapprovalPolicy
{
   /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can("nodueapproval.view");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, nodueapproval $nodueapproval): bool
    {
        // dd($LeaveApproval->AppliedLeave->employee_id);

            return $user->can("nodueapproval.view");
        
    }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(User $user): bool
    // {
    //     return $user->can('nodueapproval.create');
    // }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, nodueapproval $nodueapproval): bool
    {
        return $user->can('nodueapproval.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, nodueapproval $nodueapproval): bool
    {
        return $user->can('nodueapproval.delete');
    }
}