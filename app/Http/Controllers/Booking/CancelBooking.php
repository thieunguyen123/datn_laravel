<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Jobs\SendMail\CancelBooking as SendMailCancelBooking;
use App\Models\Booking;
use App\Models\BadmintonCourt;
use App\Models\User;
use App\Repositories\Booking\BookingRepositoryInterface;
use Illuminate\Http\Request;

class CancelBooking extends Controller
{
    public function __construct(protected BookingRepositoryInterface $bookingRepository)
    {
    }

    public function cancelBooking($id, Request $request)
    {
        try {
            $this->authorize('cancelBooking', Booking::class);
            $badmintonCourt = BadmintonCourt::find($request->badminton_court_id);
            SendMailCancelBooking::dispatch(
                User::find($request->userId),
                $request->date,
                $request->time,
                $badmintonCourt->name,
                $badmintonCourt->address);
            $this->bookingRepository->updateStatusBooking($id, $request);
            return response()->json([
                'message' => 'canceled booking successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
