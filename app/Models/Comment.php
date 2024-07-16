<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'id_parent',
        'content',
        'user_id',
        'badminton_court_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function badmintonCourt()
    {
        return $this->belongsTo(BadmintonCourt::class);
    }

    public function childComments()
    {
        return $this->hasMany(Comment::class, 'id_parent');
    }
}
