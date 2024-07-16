<?php

namespace App\Http\Controllers\BadmintonCourt;

use App\Http\Controllers\Controller;
use App\Http\Requests\BadmintonCourt\SearchBadmintonCourt;
use App\Http\Resources\BadmintonCourt;
use App\Repositories\BadmintonCourt\BadmintonCourtRepository;
use Illuminate\Http\Request;

class GetAllBadmintonCourts extends Controller
{
    public function __construct(protected BadmintonCourtRepository $badmintonCourtRepository)
    {
    }

    public function getAllBadmintonCourts(SearchBadmintonCourt $request)
    {
        try {
            $allBadmintonCourts = $this->badmintonCourtRepository->getAllBadmintonCourts($request);
            return response()->json([
                'data' => BadmintonCourt::collection($allBadmintonCourts['badmintonCourts']),
                'total' => $allBadmintonCourts['total'],
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
