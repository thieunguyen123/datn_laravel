<?php

namespace App\Http\Controllers\BadmintonCourt;

use App\Http\Controllers\Controller;
use App\Http\Resources\BadmintonCourt;
use App\Repositories\BadmintonCourt\BadmintonCourtRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShowABadmintonCourt extends Controller
{
    public function __construct(protected BadmintonCourtRepositoryInterface $badmintonCourtRepository)
    {
    }
    public function ShowABadmintonCourt(Request $request)
    {
        try {
            $id = Auth::id();
            $currentPage = $request->currentPage;
            $allBadmintonCourtOfOwner = $this->badmintonCourtRepository->showBadmintonCourtOfOwner($id,$currentPage);
            return response()->json([
                'message' => 'oke',
                'allBadmintonCourtOfOwner' =>  BadmintonCourt::collection($allBadmintonCourtOfOwner['badmintonOfOwner']),
                'total' => $allBadmintonCourtOfOwner['total'],
            ]);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json([
                'message' => $e,
            ]);
        }
    }
}
