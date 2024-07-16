<?php

namespace App\Http\Controllers\Favourite;

use App\Http\Controllers\Controller;
use App\Repositories\Favourites\FavouriteRepositoryInterface;
use Illuminate\Http\Request;

class DeleteFavouriteCourt extends Controller
{
    public function __construct(protected FavouriteRepositoryInterface $favouriteRepository)
    {
    }

    public function deleteFavouriteCourt($id)
    {
        try {
            $this->favouriteRepository->delete($id);
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
