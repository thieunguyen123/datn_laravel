<?php
namespace App\Repositories\Favourites;

use App\Models\BadmintonCourtFavorite;
use App\Repositories\BaseRepository;


class FavouriteRepository extends BaseRepository implements FavouriteRepositoryInterface
{
    public function getModel()
    {
        return BadmintonCourtFavorite::class;
    }

    public function favouriteCourt($id)
    {
        $favouriteCourts = $this->getModel()::where('user_id',$id)->get();
        return $favouriteCourts;
    }
}
