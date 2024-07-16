<?php

namespace App\Repositories\BadmintonCourt;

use App\Models\BadmintonCourt;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Contract\Database;

class BadmintonCourtRepository extends BaseRepository implements BadmintonCourtRepositoryInterface
{
    protected $tableNameBooking;
    public function __construct(protected Database $database)
    {
        $this->tableNameBooking = "bookings";
        parent::__construct();
    }

    public function getModel()
    {
        return BadmintonCourt::class;
    }

    public function showBadmintonCourtOfOwner($id,$currentPage)
    {
        $query = $this->getModel()::where('court_owner_id',$id);
        $total = $query->count();
        $badmintonOfOwners = $query->skip(($currentPage - 1) * 5)->take(5)->get();
        return [
            'total' => $total,
            'badmintonOfOwner' => $badmintonOfOwners,
        ];
    }

    public function listBadmintonCourtsNeedAccept($currentPage)
    {
        $query = $this->getModel()::where('status_id', BadmintonCourt::STATUS_DEFAULT);
        $total = $query->count();
        $badmintonCourts = $query->skip(($currentPage - 1) * 5)->take(5)->get();
        return [
            'total' => $total,
            'badmintonCourts' => $badmintonCourts
        ];
    }

    public function acceptBadmintonCourt($id)
    {
        $badmintonCourt = $this->getModel()::find($id);
        $badmintonCourt->status_id = BadmintonCourt::STATUS_ENABLE;
        $badmintonCourt->save();
    }

    public function createBadmintonCourt($id,$request)
    {
        $imageNames = [];
        foreach ($request->images as $image) {
            $fileName = time(). '_' . $image->getClientOriginalName();
            $fileName = str_replace(' ','_',$fileName);
            $imageNames[] = $fileName;
            Storage::disk('public')->putFileAs($image,$fileName);
        }
        $jsonEncodeImageNames = json_encode($imageNames);
        return $this->getModel()::create([
            'name' => $request->name,
            'description' => $request->description,
            'status_id' => BadmintonCourt::STATUS_DEFAULT,
            'price' => $request->price,
            'court_owner_id' => $id,
            'address' => $request->address,
            'image' => $jsonEncodeImageNames,
        ]);
    }

    public function updateBadmintonCourt($badmintonCourt,$request)
    {
        $badmintonCourt->name = $request->name;
        $badmintonCourt->description= $request->description;
        $badmintonCourt->price = $request->price;
        $badmintonCourt->address = $request->address;
        if ($request->oldNameImg) {
            $imagesToDelete = array_diff(json_decode($badmintonCourt->image), $request->oldNameImg);
            foreach($imagesToDelete as $img) {
                Storage::disk('public')->delete($img);
            }
        } else {
            foreach(json_decode($badmintonCourt->image) as $img){
                Storage::disk('public')->delete($img);
            }
        }
        if (isset($request->images)) {
            $imagePath = array_map(function ($img) {
                $fileName = time() . '_' . $img->getClientOriginalName();
                $fileName = str_replace(' ', '_', $fileName);
                Storage::disk('public')->putFileAs($img, $fileName);
                return $fileName;
            }, $request->images);
        } else {
            $imagePath = [];
        }
        $badmintonCourt->image = json_encode(array_merge($request->oldNameImg ?? [], $imagePath));
        $badmintonCourt->save();
        return $badmintonCourt;
    }

    public function deleteBadmintonCourt($badmintonCourt, $id, $request)
    {
        $path = "/$this->tableNameBooking/$request->idOwner";
        $refBooking = $this->database->getReference($path)->getValue();
        if ($refBooking) {
            foreach($refBooking as $key => $ref) {
                if ($ref['badminton_court_id'] == $id) {
                    $bookingDelete = $this->database->getReference("$path/$key");
                    $bookingDelete->remove();
                }
            }
        }
        $this->deleteCollection($badmintonCourt->userFavorites);
        $this->deleteCollection($badmintonCourt->comments);
        foreach(json_decode($badmintonCourt->image) as $img) {
            Storage::disk('public')->delete($img);
        }
        $badmintonCourt->delete();
    }

    protected function deleteCollection($attributes)
    {
        if ($attributes->isNotEmpty()) {
            $modelClassName = get_class($attributes->first());
            $ids = $attributes->pluck('id')->toArray();
            $modelClassName::whereIn('id', $ids)->delete();
        };
    }

    public function getAllBadmintonCourtOfOwner($idOwner)
    {
        $allBadmintonCourtsOfOwner = $this->getModel()
                                    ::where('court_owner_id',$idOwner)
                                    ->get();
        return $allBadmintonCourtsOfOwner;
    }

    public function getAllBadmintonCourts($request)
    {
        $query =  $this->getModel()::where('status_id','S6');
        if($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->address) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }
        $total = $query->count();
        $badmintonCourts = $query->skip(($request->page - 1) * 20)->take(20)->get();
        return [
            'total' => $total,
            'badmintonCourts' => $badmintonCourts,
        ];
    }

    public function allBadmintonCourts($currentPage)
    {
        $query = $this->getModel()::all();
        $total = $query->count();
        $badmintonCourts = $query->skip(($currentPage - 1) * 5)->take(5);
        return [
            'total' => $total,
            'badmintonCourts' => $badmintonCourts,
        ];
    }
}
