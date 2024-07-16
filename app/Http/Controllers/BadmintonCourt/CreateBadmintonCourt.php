<?php

namespace App\Http\Controllers\BadmintonCourt;

use App\Http\Controllers\Controller;
use App\Http\Requests\BadmintonCourt\CreateBadmintonCourt as CreateBadmintonCourtRequest;
use App\Http\Resources\BadmintonCourt;
use App\Repositories\BadmintonCourt\BadmintonCourtRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CreateBadmintonCourt extends Controller
{
    public function __construct(protected BadmintonCourtRepositoryInterface $badmintonCourtRepository)
    {
    }
    public function CreateBadmintonCourt(CreateBadmintonCourtRequest $request)
    {
        try {
            $id = Auth::id();
            $this->badmintonCourtRepository->createBadmintonCourt($id,$request);
            return response()->json([
            'message' => 'created successfully',
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
