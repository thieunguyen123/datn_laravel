<?php

namespace App\Http\Controllers\AccountManagement;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as ResourcesUser;
use App\Repositories\User\UserRepositoryInterface;

class EditAccount extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function editAccount ($id)
    {
       try {
            $account = $this->userRepository->find($id);
            return response()->json([
                'account' => new ResourcesUser($account),
            ]);
       } catch (\Exception $e) {
            dd($e);
       }
    }
}
