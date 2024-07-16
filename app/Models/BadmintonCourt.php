<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BadmintonCourt extends Model
{
    use HasFactory,SoftDeletes;

    const STATUS_DEFAULT = 'S5';
    const STATUS_ENABLE = 'S6';

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'price',
        'court_owner_id',
        'address',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'court_owner_id');
    }

    public function userFavorites()
    {
        return $this->hasMany(BadmintonCourtFavorite::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function badmintonCourtSchedule()
    {
        return $this->hasOne(BadmintonCourtSchedule::class);
    }
}
