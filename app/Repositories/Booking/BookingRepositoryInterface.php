<?php
namespace App\Repositories\Booking;

use App\Repositories\RepositoryInterface;

interface BookingRepositoryInterface extends RepositoryInterface
{
    public function getModel();
    public function createBookingRealtime($request, $id);
    public function listBookingOfOwner($idOwner, $currentPage, $dateFilter, $timeFilter, $statusFilter);
    public function updateStatusBooking($id, $request);
    public function acceptBooking($id, $request);
    public function deleteBooking($id, $request);
    public function listBookingOfUser($id, $idOwner, $idCourt);
}
