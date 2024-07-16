<?php

namespace App\Http\Controllers\BadmintonCourt;

use App\Http\Controllers\Controller;
use App\Http\Requests\BadmintonCourt\UpdateBadmintonCourt as UpdateBadmintonCourtRequest;
use App\Http\Resources\BadmintonCourt;
use App\Repositories\BadmintonCourt\BadmintonCourtRepositoryInterface;
use Illuminate\Http\Request;

class UpdateBadmintonCourt extends Controller
{
    public function __construct(protected BadmintonCourtRepositoryInterface $badmintonCourtRepository)
    {
    }
    public function updateBadmintonCourt($id,UpdateBadmintonCourtRequest $request)
    {
        try {
            $badmintonCourt = $this->badmintonCourtRepository->find($id);
            $this->authorize('update',$badmintonCourt);
            $badmintonCourtUpdate = $this->badmintonCourtRepository->updateBadmintonCourt($badmintonCourt,$request);
            return response()->json([
                'message' => 'oke',
                'badmintonCourt' => new BadmintonCourt($badmintonCourtUpdate)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ]);
        }
    }
}
