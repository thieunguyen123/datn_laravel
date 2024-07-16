<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class ListUsers extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }
    public function getAllUsers(Request $request)
    {
        try {
            $result = $this->userRepository->getListUsers($request);
            return response()->json([
                'message' => 'oke',
                'allUsers' =>  User::collection($result['allUsers']),
                'totalUsers' => $result['totalUsers'],
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
