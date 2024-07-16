<?php

namespace App\Http\Controllers\AccountManageMent;

use App\Http\Controllers\Controller;
use App\Http\Resources\User;
use Illuminate\Support\Facades\Auth;

class EditItsMe extends Controller
{
    public function editItsMe()
    {
        try {
            $user = Auth::user();
            return response()->json([
                'message' => 'oke',
                'user' => new User($user),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
