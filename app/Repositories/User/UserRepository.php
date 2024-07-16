<?php
namespace App\Repositories\User;

use App\Models\Booking;
use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Database;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $tableName;
    public function __construct(protected Database $database)
    {
        $this->tableName = "bookings";
        parent::__construct();
    }

    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function resetPassword($query)
    {
        $tokenReset = Str::random(20);
        $timeTokenExpires = Carbon::now()->addMinutes(3);
        $query->token_reset = $tokenReset;
        $query->token_reset_expire = $timeTokenExpires;
        $query->save();
        return $tokenReset;
    }

    public function updatePassword($request)
    {
        $user = $this->getModel()::where('email',$request->email)->first();
        $timeExpire = $user->token_reset_expire;
        if (Carbon::now()->greaterThan($timeExpire)) {
            return response()->json([
                'message' => 'Token is expired, please resend token.',
            ],422);
        };
        $token = $user->token_reset;
        if($request->token != $token) {
            return response()->json([
                'message' => 'Token is invalid.',
            ],422);
        }
        $user->password = bcrypt($request->password);
        $user->token_reset = null;  // token chỉ được dùng 1 lần
        $user->token_reset_expire = null;
        $user->save();
        return response()->json([
            'message' => 'You have successfully updated your password',
        ],200);
    }

    public function deleteAccount($id)
    {
        $account = $this->getModel()::find($id);
        if ($account->image && $account->image !== User::AVT_DEFAULT){
            Storage::disk('public')->delete($account->image);
        }
        if ($account->role_id === User::ROLE_ADMIN) {
            $account->delete();
        } elseif ($account->role_id === User::ROLE_OWNER) {
            $this->database->getReference("/$this->tableName/$id")->remove();
            $this->deleteCollection($account->badmintonCourts);
            $this->deleteCollection($account->comments);
            $account->delete();
        } else {
            $bookingOfUsers = $this->database->getReference("/$this->tableName")->getValue();
            foreach($bookingOfUsers as $key => $value) {
                $path = "/$this->tableName/$key";
                foreach($value as $key => $element ) {
                    if ($element['user_id'] == $id && $element['status_id'] != Booking::STATUS_CONFIRMED) {
                        $this->database->getReference($path . "/$key")->remove();
                    }
                }
            }
            $this->deleteCollection($account->comments);
            $this->deleteCollection($account->badmintonCourtFavorites);
            $account->delete();
        }
    }

    protected function deleteCollection($attributes)
    {
        if ($attributes->isNotEmpty()) {
            $modelClassName = get_class($attributes->first());
            $ids = $attributes->pluck('id')->toArray();
            $modelClassName::whereIn('id', $ids)->delete();
        }
    }

    public function findUser($email)
    {
        $info = User::where('email',$email)->first();
        return $info;
    }

    public function getListUsers($request)
    {
        $currentPage = (int)$request->input('page');
        $keySearch = $request->search;
        $query = $this->getModel()::orderBy('updated_at', 'desc');
        if ($keySearch) {
            $query->where('email', 'like', '%' . $keySearch . '%');
        }
        $totalUsers = $query->count();
        $allUsers = $query->skip(($currentPage - 1) * 10)->take(10)->get();
        return [
            'totalUsers' => $totalUsers,
            'allUsers' => $allUsers,
        ];
    }
}
