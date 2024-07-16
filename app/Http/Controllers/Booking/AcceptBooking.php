<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Jobs\SendMail\AcceptBooking as SendMailAcceptBooking;
use App\Models\BadmintonCourt;
use App\Models\Booking;
use App\Models\User;
use App\Repositories\Booking\BookingRepositoryInterface;
use Illuminate\Http\Request;

class AcceptBooking extends Controller
{
    public function __construct(protected BookingRepositoryInterface $bookingRepository)
    {
    }

    public function acceptBooking($id, Request $request)
    {
        try {
            $this->authorize('acceptBooking', Booking::class);
            $badmintonCourt = BadmintonCourt::find($request->badminton_court_id);
            SendMailAcceptBooking::dispatch(
                User::find($request->userId),
                $request->date,
                $request->time,
                $badmintonCourt->name,
                $badmintonCourt->address);
            $this->bookingRepository->acceptBooking($id,$request);
            return response()->json([
                'message' => 'booking has been accepted',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
