<?php

namespace App\Http\Controllers\BadmintonCourt;

use App\Http\Controllers\Controller;
use App\Http\Resources\BadmintonCourt;
use App\Repositories\BadmintonCourt\BadmintonCourtRepositoryInterface;
use Illuminate\Http\Request;

class AllBadmintonCourts extends Controller
{
    public function __construct(protected BadmintonCourtRepositoryInterface $badmintonCourtRepository)
    {
    }

    public function allBadmintonCourts(Request $request)
    {
        try {
            $currentPage = $request->currentPage;
            $badmintonCourts = $this->badmintonCourtRepository->allBadmintonCourts($currentPage);
            return response()->json([
                'message' => 'oke',
                'total' => $badmintonCourts['total'],
                'badmintonCourts' => BadmintonCourt::collection($badmintonCourts['badmintonCourts']),
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
