<?php

namespace App\Policies;

use App\Models\BadmintonCourtSchedule;
use App\Models\User;

class SchedulesPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function makeSchedule(User $user)
    {
        return $user->role_id === User::ROLE_OWNER;
    }
}
