<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\CreateBooking as CreateBookingRequest;
use App\Jobs\SendMail\CreateBooking as SendMailCreateBooking;
use App\Models\User;
use App\Repositories\Booking\BookingRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CreateBooking extends Controller
{
    public function __construct(protected BookingRepositoryInterface $bookingRepository)
    {
    }

    public function createBooking(CreateBookingRequest $request)
    {
        try {
            $id = Auth::id();
            SendMailCreateBooking::dispatch(User::find($request->court_owner_id));
            $this->bookingRepository->createBookingRealtime($request,$id);
            return response()->json([
                'message' => 'created successfully booking.',
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
