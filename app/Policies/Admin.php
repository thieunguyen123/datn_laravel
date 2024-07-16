<?php

namespace App\Policies;

use App\Models\User;

class Admin
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $currentUser,User $user)
    {
        return $currentUser->role_id === User::ROLE_ADMIN || $currentUser->id === $user->id;
    }

    public function delete(User $currentUser,User $user)
    {
        return $currentUser->role_id === User::ROLE_ADMIN || $currentUser->id === $user->id;
    }
}
