<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function acceptBooking(User $user)
    {
        return $user->role_id === User::ROLE_OWNER;
    }

    public function cancelBooking(User $user)
    {
        return $user->role_id === User::ROLE_OWNER;
    }

    public function deleteBooking(User $user)
    {
        return $user->role_id === User::ROLE_OWNER;
    }
}
