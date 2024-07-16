<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Resources\Booking;
use App\Repositories\Booking\BookingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListBookingOfOwner extends Controller
{
    public function __construct(protected BookingRepositoryInterface $bookingRepository)
    {
    }

    public function listBookingOfOwner(Request $request)
    {
        try {
            $id = Auth::id();
            $currentPage = $request->page;
            $dateFilter = $request->dateFilter;
            $timeFilter = $request->timeFilter;
            $statusFilter = $request->statusFilter;
            $listBookingOfOwner = $this->bookingRepository->listBookingOfOwner($id,$currentPage,$dateFilter,$timeFilter,$statusFilter);
            return response()->json([
                'message' => 'oke',
                'listBookingOfOwner' => Booking::collection($listBookingOfOwner['allBookings']),
                'totalBookings' => $listBookingOfOwner['totalBookings'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
