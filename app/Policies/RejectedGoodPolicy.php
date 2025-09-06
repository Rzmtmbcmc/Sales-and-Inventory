<?php

namespace App\Policies;

use App\Models\RejectedGood;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RejectedGoodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->Role === 'Owner' || $user->Role === 'Manager';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RejectedGood $rejectedGood): bool
    {
        return $user->Role === 'Owner' || $user->Role === 'Manager' || $rejectedGood->branch_id == $user->branch_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->Role === 'Owner' || $user->Role === 'Manager';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RejectedGood $rejectedGood): bool
    {
        return $user->Role === 'Owner' || $user->Role === 'Manager' || $rejectedGood->branch_id == $user->branch_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RejectedGood $rejectedGood): bool
    {
        return $user->Role === 'Owner' || $user->Role === 'Manager' || $rejectedGood->branch_id == $user->branch_id;
    }
}