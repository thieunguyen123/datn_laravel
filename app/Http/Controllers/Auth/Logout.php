<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;


class Logout extends Controller
{
    public function logout()
    {
        try {
            auth()->logout();
            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ]);
        }
    }
}
