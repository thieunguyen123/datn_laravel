<?php

namespace App\Http\Controllers\BadmintonCourt;

use App\Http\Controllers\Controller;
use App\Jobs\SendMail\DeleteBadmintonCourt as SendMailDeleteBadmintonCourt;
use App\Models\BadmintonCourt;
use App\Repositories\BadmintonCourt\BadmintonCourtRepositoryInterface;
use Illuminate\Http\Request;

class DeleteBadmintonCourt extends Controller
{
    public function __construct(protected BadmintonCourtRepositoryInterface $badmintonCourtRepository)
    {
    }

    public function deleteBadmintonCourt($id, Request $request) {
        try {
            $badmintonCourt = $this->badmintonCourtRepository->find($id);
            $this->authorize('delete',$badmintonCourt);
            $this->badmintonCourtRepository->deleteBadmintonCourt($badmintonCourt, $id, $request);
            SendMailDeleteBadmintonCourt::dispatch($badmintonCourt);
            return response()->json([
                'message' => 'deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ]);
        }
    }
}
