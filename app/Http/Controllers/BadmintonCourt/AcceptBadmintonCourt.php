<?php

namespace App\Http\Controllers\BadmintonCourt;

use App\Http\Controllers\Controller;
use App\Jobs\SendMail\AcceptBadmintonCourt as SendMailAcceptBadmintonCourt;
use App\Models\BadmintonCourt;
use App\Repositories\BadmintonCourt\BadmintonCourtRepositoryInterface;
use Illuminate\Http\Request;

class AcceptBadmintonCourt extends Controller
{
    public function __construct(protected BadmintonCourtRepositoryInterface $badmintonCourtRepository)
    {
    }

    public function acceptBadmintonCourt($id)
    {
        try {
            $this->badmintonCourtRepository->acceptBadmintonCourt($id);
            SendMailAcceptBadmintonCourt::dispatch(BadmintonCourt::find($id));
            return response()->json([
                'message' => 'oke',
            ],200);
        } catch (\Exception $e) {
            \Log::info($e);
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
