<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadmintonCourtSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'badminton_court_id',
        'date',
        'empty_time',
    ];

    public function badmintonCourt()
    {
        return $this->belongsTo(BadmintonCourt::class);
    }
}
