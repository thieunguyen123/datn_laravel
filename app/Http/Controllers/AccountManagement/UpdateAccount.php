<?php

namespace App\Http\Controllers\AccountManageMent;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountManagement\UpdateAccount as UpdateAccountRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UpdateAccount extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function updateAccount($id,UpdateAccountRequest $request)
    {
        try {
            $account = $this->userRepository->find($id);
            $this->authorize('update',$account);
            $account = $this->userRepository->update($id,[
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'gender' => $request->input('gender'),
                'role_id' => $request->input('role_id'),
            ]);
            if ($request->image) {
                $file = $request->image;
                $oldImage = Storage::disk('public')->path($account->image);
                if (md5_file($file) !== md5_file($oldImage)) {
                    if ($account->image !== User::AVT_DEFAULT){
                        Storage::disk('public')->delete($account->image);
                    }
                    $fileName= time().'_'.$file->getClientOriginalName();
                    $fileName = str_replace(' ','_',$fileName);
                    Storage::disk('public')->putFileAs($file, $fileName);
                    $account->image = $fileName;
                    $account->save();
                }
            }
            return response()->json([
                'message' => 'Created Account Successfully',
                'account' => $account,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
