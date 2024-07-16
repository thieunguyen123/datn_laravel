<?php
namespace App\Repositories\BadmintonCourt;

use App\Repositories\RepositoryInterface;

interface BadmintonCourtRepositoryInterface extends RepositoryInterface
{
    public function getModel();
    public function showBadmintonCourtOfOwner($id,$currentPage);
    public function createBadmintonCourt($id,$request);
    public function updateBadmintonCourt($badmintonCourt,$request);
    public function deleteBadmintonCourt($badmintonCourt, $id, $request);
    public function getAllBadmintonCourtOfOwner($idOwner);
    public function getAllBadmintonCourts($request);
    public function acceptBadmintonCourt($id);
    public function listBadmintonCourtsNeedAccept($currentPage);
    public function allBadmintonCourts($currentPage);
}
