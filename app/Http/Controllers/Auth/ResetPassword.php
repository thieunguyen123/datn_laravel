<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPassword;
use App\Http\Requests\Auth\ResetPassword as AuthResetPassword;
use App\Jobs\SendMail\ForgotPassword as SendMailResetPassword;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;

class ResetPassword extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function forgotPassword(ForgotPassword $request)
    {
        try {
            $query = User::where('email',$request->email)->first();
            if (!$query) {
                return response()->json([
                    'message' => 'email is not found',
                ],500);
            }
            $tokenReset = $this->userRepository->resetPassword($query);
            SendMailResetPassword::dispatch($query->email,$tokenReset);
            return response()->json([
                'message' => 'oke',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }

    public function resetPassword(AuthResetPassword $request)
    {
        return $this->userRepository->updatePassword($request);
    }
}
