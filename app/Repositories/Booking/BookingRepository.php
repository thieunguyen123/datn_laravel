<?php

namespace App\Repositories\Booking;

use App\Models\Booking;
use App\Repositories\BaseRepository;
use Kreait\Firebase\Contract\Database;

class BookingRepository extends BaseRepository implements BookingRepositoryInterface
{
    protected $tableName;
    protected $tableNameSchedule;
    public function __construct(protected Database $database)
    {
        $this->tableName = "bookings";
        $this->tableNameSchedule = "badminton_court_schedules";
    }

    public function getModel()
    {
        return Booking::class;
    }

    public function listBookingOfUser($id, $idOwner, $idCourt)
    {
        $path = "/$this->tableName/$idOwner";
        $ref = $this->database->getReference($path)->getValue();
        $filteredRef = array_filter($ref , function($element) use($id, $idCourt) {
            if ($element['user_id'] == $id && $element['badminton_court_id'] == $idCourt) {
                return true;
            }
            return false;
        });
        $result = [];
        foreach($filteredRef as $key => $element) {
            $element['key'] = $key;
            $result[] = $element;
        }
        return $result;
    }

    public function listBookingOfOwner($idOwner, $currentPage, $dateFilter, $timeFilter, $statusFilter)
    {
        $path = "/$this->tableName/$idOwner";
        $ref = $this->database->getReference($path)->getValue();
        $filteredRef = array_filter($ref, function($element) use($dateFilter, $timeFilter, $statusFilter) {
            if (!empty($dateFilter) && $element['day_booking'] != $dateFilter) {
                return false;
            }
            if (!empty($timeFilter) && $element['time_booking'] != $timeFilter) {
                return false;
            }
            if (!empty($statusFilter) && $element['status_id'] != $statusFilter) {
                return false;
            }
            return true;
        });
        $totalItems = count($filteredRef);
        $perPage = 10;
        $offset = ($currentPage - 1) * $perPage;
        $paginatedRef = array_slice($filteredRef, $offset, $perPage);
        $result = [];
        foreach ($paginatedRef as $key => $element) {
            $element['key'] = $key;
            $element['court_owner_id'] = $idOwner;
            $result[] = $element;
        }
        return [
            'totalBookings' => $totalItems,
            'allBookings' => $result,
        ];
    }

    public function updateStatusBooking($id, $request)
    {
        $path = "/$this->tableName/$request->idOwner/$id";
        $ref = $this->database->getReference($path);
        $booking = $ref->getValue();
        $booking['status_id'] = $this->getModel()::STATUS_CANCEL;
        $ref->set($booking);
    }

    public function acceptBooking($id, $request)
    {
        $path = "/$this->tableName/$request->idOwner/$id";
        $ref = $this->database->getReference($path);
        $booking = $ref->getValue();
        if ($booking['status_id'] === $this->getModel()::STATUS_DEFAULT) {
            $booking['status_id'] = $this->getModel()::STATUS_CONFIRMED;
        };
        $ref->set($booking);
        $pathSchedule = "/$this->tableNameSchedule/{$booking['badminton_court_id']}/{$booking['day_booking']}";
        $refSchedule = $this->database->getReference($pathSchedule);
        $schedule = $refSchedule->getValue();
        $schedule = array_diff($schedule,$booking['time_booking']);
        $refSchedule->set($schedule);
    }

    public function createBookingRealtime($request, $id)
    {
        $path = "/$this->tableName/$request->court_owner_id";
        $this->database->getReference($path)->push([
            'badminton_court_id' => $request->badminton_court_id,
            'day_booking' => $request->day_booking,
            'status_id' => $this->getModel()::STATUS_DEFAULT,
            'user_id' => $id,
            'time_booking' => $request->time_booking,
        ]);
    }

    public function deleteBooking($id, $request)
    {
        $path = "/$this->tableName/$request->idOwner/$id";
        $this->database->getReference($path)->remove();
    }
}
