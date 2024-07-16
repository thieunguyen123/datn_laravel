<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register as RegisterRequest;
use App\Jobs\SendMail\RegisterSuccessfully as SendMailRegister;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class Register extends Controller
{

    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function register(RegisterRequest $request)
    {
        try {
            $path = User::AVT_DEFAULT;
            $user = $this->userRepository->create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'gender' => $request->input('gender'),
                'role_id' => $request->input('role_id'),
                'image' => $path,
                'password' => bcrypt($request->input('password')),
            ]);

            $nameEmail = $user->email;
            $nameUser = $user->first_name;
            $password = $request->input('password');
            SendMailRegister::dispatch($nameEmail,$nameUser,$password);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user
            ]);

        } catch (\Throwable $th) {
            Log::info($th);
            return response()->json([
                'error' => 'Registration failed',
                'message' => $th
            ], 500);
        }
    }
}
