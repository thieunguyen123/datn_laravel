<?php

namespace App\Policies;

use App\Models\BadmintonCourt;
use App\Models\User;

class BadmintonCourtPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, BadmintonCourt $badmintonCourt)
    {
        return $user->id === $badmintonCourt->court_owner_id || $user->role_id == User::ROLE_ADMIN;
    }

    public function delete(User $user, BadmintonCourt $badmintonCourt)
    {
        return $user->id === $badmintonCourt->court_owner_id || $user->role_id == User::ROLE_ADMIN;
    }
}
