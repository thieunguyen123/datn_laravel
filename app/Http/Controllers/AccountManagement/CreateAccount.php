<?php

namespace App\Http\Controllers\AccountManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountManagement\CreateAccount as CreateAccountRequest;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class CreateAccount extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function createAccount(CreateAccountRequest $request)
    {
        try {
            if ($request->image) {
                $file = $request->image;
                $fileName= time().'_'.$file->getClientOriginalName();
                $fileName = str_replace(' ','_',$fileName);
                Storage::disk('public')->putFileAs($file, $fileName);
                $user = $this->userRepository->create([
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'phone_number' => $request->input('phone_number'),
                    'gender' => $request->input('gender'),
                    'role_id' => $request->input('role_id'),
                    'image' => $fileName,
                    'password' => bcrypt($request->input('password')),
                ]);
            } else {
                $user = $this->userRepository->create([
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'phone_number' => $request->input('phone_number'),
                    'gender' => $request->input('gender'),
                    'role_id' => $request->input('role_id'),
                    'image' => User::AVT_DEFAULT,
                    'password' => bcrypt($request->input('password')),
                ]);
            }
            return response()->json([
                'message' => 'Created Account Successfully',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
            // dd($e);
        }
    }
}
