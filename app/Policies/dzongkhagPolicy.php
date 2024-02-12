<?php

namespace App\Policies;

use App\Models\dzongkhag;
use Chiiya\FilamentAccessControl\Models\FilamentUser as User;

class dzongkhagPolicy
{
              /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can("dzongkhag.view");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, dzongkhag $dzongkhag): bool
    {
        // dd($LeaveApproval->AppliedLeave->employee_id);

            return $user->can("dzongkhag.view");
        
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('dzongkhag.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, dzongkhag $dzongkhag): bool
    {
        return $user->can('dzongkhag.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, dzongkhag $dzongkhag): bool
    {
        return $user->can('dzongkhag.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
  
}