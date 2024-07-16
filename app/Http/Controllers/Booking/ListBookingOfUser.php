<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListBookingOfUser as ResourcesListBookingOfUser;
use App\Repositories\Booking\BookingRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ListBookingOfUser extends Controller
{
    public function __construct(protected BookingRepositoryInterface $bookingRepository)
    {
    }

    public function listBookingOfUser($idOwner, $idCourt)
    {
        $id = Auth::id();
        $listBookings = $this->bookingRepository->listBookingOfUser($id, $idOwner, $idCourt);
        try {
            return response()->json([
                'message' => 'oke',
                'listBookings' => ResourcesListBookingOfUser::collection($listBookings),
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e . 'failed',
            ],500);
        }
    }
}
