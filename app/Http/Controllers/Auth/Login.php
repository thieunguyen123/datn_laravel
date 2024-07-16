<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Repositories\User\UserRepositoryInterface;

class Login extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth()->setTTL(10080)->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $infoAccount =  $this->userRepository->findUser($credentials['email']);
        return $this->respondWithToken($token,$infoAccount);
    }

    public function loginWithSocialite($provider)
    {
        $userProvider = Socialite::driver($provider)->stateless()->user();
        return $this->handleSocialLogin($provider, $userProvider);
    }

    protected function handleSocialLogin($provider,$userProvider)
    {
        $providerId = $userProvider->id;
        $user = User::where(function($query) use ($provider, $providerId, $userProvider) {
            $query->where(function($query) use ($provider, $providerId) {
                $query->where('provider', $provider)
                      ->where('provider_id', $providerId);
            })
            ->orWhere(function($query) use ($userProvider) {
                $query->where('email', $userProvider->email);
            });
        })->first();

        if (!$user) {
            $user = new User();
            if ($provider === User::FACEBOOK) {
                $arrayName = explode(" ",$userProvider->name);
                $user->first_name = $arrayName[0];
                $user->last_name = implode(" ",array_slice($arrayName, 1));
            } else {
                $user->first_name = $userProvider->user['family_name'];
                $user->last_name = $userProvider->user['given_name'];
            }
            $user->email = $userProvider->email;
            $user->provider_id = $providerId;
            $user->provider = $provider;
            $user->password = Hash::make(rand());
            $user->role_id = User::ROLE_DEFAULT;
            $user->image = User::AVT_DEFAULT;
            $user->save();
        }
        $token = auth()->login($user);
        return $this->respondWithToken($token,$user);
    }

    protected function respondWithToken($token,$infoAccount)
    {
        return response()->json([
            'message' => 'login successfully',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 24 * 7,
            'userId' => $infoAccount->id,
            'role_id' => $infoAccount->role_id
        ]);
    }
}
