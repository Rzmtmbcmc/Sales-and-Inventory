<?php

namespace App\Policies;

use App\Models\PastOrder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PastOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->Role === 'Owner';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PastOrder $pastOrder): bool
    {
        return $user->Role === 'Owner' || $pastOrder->branch_id == $user->branch_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PastOrder $pastOrder): bool
    {
        return $user->Role === 'Owner' || $pastOrder->branch_id == $user->branch_id;
    }
}