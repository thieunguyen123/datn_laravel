<?php

namespace App\Http\Controllers\BadmintonCourt;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\GetEmptyTime;
use App\Http\Requests\Schedule\MakeSchedule as MakeScheduleRequest;
use App\Http\Resources\GetEmptyTime as ResourcesGetEmptyTime;
use App\Models\BadmintonCourtSchedule;
use App\Repositories\Schedule\ScheduleRepositoryInterface;

class MakeSchedule extends Controller
{
    public function __construct(protected ScheduleRepositoryInterface $scheduleRepository)
    {
    }

    public function makeSchedule(MakeScheduleRequest $request)
    {
        try {
            $this->authorize('makeSchedule', BadmintonCourtSchedule::class);
            $this->scheduleRepository->makeSchedule($request);
            return response()->json([
                'message' => 'create schedule oke',
            ]);
        } catch (\Exception $e) {
            \Log::info($e);
            return response()->json([
                'message' => $e,
            ],500);
        }
    }

    public function badmintonCourtEmptyTime(GetEmptyTime $request)
    {
        try {
            $emptyTime = $this->scheduleRepository->getEmptyTime($request);
            return response()->json([
                'message' => 'oke',
                'emptyTime' => new ResourcesGetEmptyTime($emptyTime),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
