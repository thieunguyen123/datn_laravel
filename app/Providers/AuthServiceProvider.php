<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\BadmintonCourt;
use App\Models\BadmintonCourtSchedule;
use App\Models\Booking;
use App\Models\Comment;
use App\Models\User;
use App\Policies\Admin;
use App\Policies\BadmintonCourtPolicy;
use App\Policies\BookingPolicy;
use App\Policies\CommentPolicy;
use App\Policies\SchedulesPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => Admin::class,
        BadmintonCourt::class => BadmintonCourtPolicy::class,
        Booking::class => BookingPolicy::class,
        BadmintonCourtSchedule::class => SchedulesPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
