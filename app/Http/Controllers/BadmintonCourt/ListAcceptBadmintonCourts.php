<?php

namespace App\Http\Controllers\BadmintonCourt;

use App\Http\Controllers\Controller;
use App\Http\Resources\BadmintonCourt;
use App\Repositories\BadmintonCourt\BadmintonCourtRepositoryInterface;
use Illuminate\Http\Request;

class ListAcceptBadmintonCourts extends Controller
{
    public function __construct(protected BadmintonCourtRepositoryInterface $badmintonCourtRepository)
    {
    }

    public function listAcceptBadmintonCourts(Request $request)
    {
        try {
            $currentPage = $request->currentPage;
            $listBadmintonCourts =$this->badmintonCourtRepository->listBadmintonCourtsNeedAccept($currentPage);
            return response()->json([
                'message' => 'oke',
                'total' => $listBadmintonCourts['total'],
                'badmintonCourts' => BadmintonCourt::collection($listBadmintonCourts['badmintonCourts'])
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e
            ],500);
        }
    }
}
