<?php

namespace App\Http\Controllers\Favourite;

use App\Http\Controllers\Controller;
use App\Repositories\Favourites\FavouriteRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetFavouriteCourt extends Controller
{
    public function __construct(protected FavouriteRepositoryInterface $favouriteRepository)
    {
    }

    public function getFavouriteCourt()
    {
        try {
            $id = Auth::id();
            $favouriteCourt = $this->favouriteRepository->favouriteCourt($id);
            return response()->json([
                'message' => 'oke',
                'favourite_court' => $favouriteCourt,
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
