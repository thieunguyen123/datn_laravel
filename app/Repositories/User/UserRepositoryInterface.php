<?php
namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function resetPassword($query);
    public function updatePassword($request);
    public function deleteAccount($id);
    public function findUser($email);
    public function getListUsers($request);
}
