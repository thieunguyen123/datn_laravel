<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllCode extends Model
{
    use HasFactory;
    protected $table = 'all_codes';

    // public function users()
    // {
    //     return $this->hasMany(User::class, 'role_id', 'key_map');
    // }
}
