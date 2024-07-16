<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepository::class);
        $this->app->singleton(
            \App\Repositories\Booking\BookingRepositoryInterface::class,
            \App\Repositories\Booking\BookingRepository::class);
        $this->app->singleton(
            \App\Repositories\BadmintonCourt\BadmintonCourtRepositoryInterface::class,
            \App\Repositories\BadmintonCourt\BadmintonCourtRepository::class);
        $this->app->singleton(
            \App\Repositories\Schedule\ScheduleRepositoryInterface::class,
            \App\Repositories\Schedule\ScheduleRepository::class);
        $this->app->singleton(
            \App\Repositories\Comments\CommentRepositoryInterface::class,
            \App\Repositories\Comments\CommentRepository::class);
        $this->app->singleton(
            \App\Repositories\Favourites\FavouriteRepositoryInterface::class,
            \App\Repositories\Favourites\FavouriteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
