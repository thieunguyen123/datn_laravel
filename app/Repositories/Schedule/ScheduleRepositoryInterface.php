<?php
namespace App\Repositories\Schedule;

use App\Repositories\RepositoryInterface;

interface ScheduleRepositoryInterface extends RepositoryInterface
{
    public function makeSchedule($request);
    public function getEmptyTime($request);
}
