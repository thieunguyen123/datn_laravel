<?php

namespace App\Http\Controllers\AccountManagement;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;

class DeleteAccount extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function deleteAccount($id)
    {
        try {
            $account = $this->userRepository->find($id);
            $this->authorize('delete',$account);
            $this->userRepository->deleteAccount($id);
            return response()->json([
                'message' => 'deleted successfully',
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
