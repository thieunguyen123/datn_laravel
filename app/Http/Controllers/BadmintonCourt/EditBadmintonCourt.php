<?php

namespace App\Http\Controllers\BadmintonCourt;

use App\Http\Controllers\Controller;
use App\Http\Resources\BadmintonCourt;
use App\Repositories\BadmintonCourt\BadmintonCourtRepositoryInterface;

class EditBadmintonCourt extends Controller
{
    public function __construct(protected BadmintonCourtRepositoryInterface $badmintonCourtRepository)
    {
    }
    public function editBadmintonCourt($id)
    {
        try {
            $badmintonCourt = $this->badmintonCourtRepository->find($id);
            return response()->json([
                'message' => 'oke',
                'badmintonCourt' => new BadmintonCourt($badmintonCourt),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
