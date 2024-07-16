<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    const STATUS_DEFAULT = "S1";
    const STATUS_CANCEL = "S4";
    const STATUS_CONFIRMED = "S2";
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'status_id',
        'user_id',
        'court_owner_id',
        'time_booking_start',
        'time_booking_end',
        'day_booking',
        'badminton_court_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function courtOwner()
    {
        return $this->belongsTo(User::class, 'court_owner_id');
    }

    public function badmintonCourt()
    {
        return $this->belongsTo(BadmintonCourt::class);
    }
}
