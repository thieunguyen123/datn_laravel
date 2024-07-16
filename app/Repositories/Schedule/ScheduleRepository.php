<?php
namespace App\Repositories\Schedule;

use App\Models\BadmintonCourtSchedule;
use App\Repositories\BaseRepository;
use Kreait\Firebase\Contract\Database;

class ScheduleRepository extends BaseRepository implements ScheduleRepositoryInterface
{
    protected $tableName;
    public function __construct(protected Database $database)
    {
        $this->tableName = "badminton_court_schedules";
    }

    public function getModel()
    {
        return BadmintonCourtSchedule::class;
    }

    public function makeSchedule($request)
    {
        $path = "/$this->tableName/$request->badminton_court_id/$request->date";
        $this->database->getReference($path)->set($request->empty_times);
    }

    public function getEmptyTime($request)
    {
        $emptyTime = $this->database->getReference("/$this->tableName/{$request->badminton_court_id}/{$request->date}")->getValue();
        return $emptyTime;
    }
}
