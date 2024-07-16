<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Repositories\Booking\BookingRepositoryInterface;
use Illuminate\Http\Request;

class DeleteBooking extends Controller
{
    public function __construct(protected BookingRepositoryInterface $bookingRepository)
    {
    }

    public function deleteBooking($id, Request $request)
    {
        try {
            $this->authorize('deleteBooking', Booking::class);
            $this->bookingRepository->deleteBooking($id, $request);
            return response()->json([
                'message' => 'deleted booking successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
