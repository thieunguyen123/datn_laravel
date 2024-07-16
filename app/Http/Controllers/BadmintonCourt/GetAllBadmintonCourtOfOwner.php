<?php

namespace App\Http\Controllers\BadmintonCourt;

use App\Http\Controllers\Controller;
use App\Http\Resources\GetAllBadmintonCourtsOfOwner;
use App\Repositories\BadmintonCourt\BadmintonCourtRepositoryInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class GetAllBadmintonCourtOfOwner extends Controller
{
    public function __construct(protected BadmintonCourtRepositoryInterface $badmintonCourtRepository)
    {
    }

    public function getAllBadmintonCourt()
    {
        try {
            $idOwner = Auth::id();
            $allBadmintonCourtsOfOwner = $this->badmintonCourtRepository->getAllBadmintonCourtOfOwner($idOwner);
            return response()->json([
                'message' => 'oke',
                'allBadmintonCourtsOfOwner' => GetAllBadmintonCourtsOfOwner::collection($allBadmintonCourtsOfOwner),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }

    }
}
