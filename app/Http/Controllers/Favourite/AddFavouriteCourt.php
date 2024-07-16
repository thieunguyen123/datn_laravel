<?php

namespace App\Http\Controllers\Favourite;

use App\Http\Controllers\Controller;
use App\Repositories\Favourites\FavouriteRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AddFavouriteCourt extends Controller
{
    public function __construct(protected FavouriteRepositoryInterface $favouriteRepository)
    {
    }

    public function addFavouriteCourt($idBadmintonCourt)
    {
        try {
            $id = Auth::id();
            $this->favouriteRepository->create([
                'badminton_court_id' => $idBadmintonCourt,
                'user_id' => $id,
            ]);
            return response()->json([
                'message' => 'oke',
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
