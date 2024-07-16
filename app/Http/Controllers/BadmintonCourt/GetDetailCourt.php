<?php

namespace App\Http\Controllers\BadmintonCourt;

use App\Http\Controllers\Controller;
use App\Http\Resources\BadmintonCourt;
use App\Repositories\BadmintonCourt\BadmintonCourtRepositoryInterface;
use Illuminate\Http\Request;

class GetDetailCourt extends Controller
{
    public function __construct(protected BadmintonCourtRepositoryInterface $badmintonCourtRepository)
    {
    }

    public function getDetailCourt($id)
    {
        try {
            $badmintonCourt = $this->badmintonCourtRepository->find($id);
            return response()->json([
                'message' => 'oke',
                'badmintonCourt' => new BadmintonCourt($badmintonCourt),
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
