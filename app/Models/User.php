<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword ;

class User extends Authenticatable implements JWTSubject,CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, CanResetPasswordTrait;

    const ROLE_DEFAULT = 'R3';
    const ROLE_ADMIN = 'R1';
    const ROLE_OWNER = 'R2';
    const AVT_DEFAULT = 'avt_default.png';
    const FACEBOOK = 'facebook';
    const GOOGLE = 'google';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'gender',
        'role_id',
        'image',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // public function allCode()
    // {
    //     return $this->belongsTo(AllCode::class, 'role_id', 'key_map');
    // }
    public function badmintonCourts()
    {
        return $this->hasMany(BadmintonCourt::class, 'court_owner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function courtOwnerBookings()
    {
        return $this->hasMany(Booking::class, 'court_owner_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function badmintonCourtFavorites()
    {
        return $this->hasMany(BadmintonCourtFavorite::class);
    }
}
