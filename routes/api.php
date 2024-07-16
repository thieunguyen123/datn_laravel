<?php

use App\Http\Controllers\AccountManagement\CreateAccount;
use App\Http\Controllers\AccountManagement\DeleteAccount;
use App\Http\Controllers\AccountManagement\EditAccount;
use App\Http\Controllers\AccountManageMent\EditItsMe;
use App\Http\Controllers\AccountManageMent\UpdateAccount;
use App\Http\Controllers\Admin\ListUsers;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\ResetPassword;
use App\Http\Controllers\BadmintonCourt\AcceptBadmintonCourt;
use App\Http\Controllers\BadmintonCourt\AllBadmintonCourts;
use App\Http\Controllers\BadmintonCourt\CreateBadmintonCourt;
use App\Http\Controllers\BadmintonCourt\DeleteBadmintonCourt;
use App\Http\Controllers\BadmintonCourt\EditBadmintonCourt;
use App\Http\Controllers\BadmintonCourt\GetAllBadmintonCourtOfOwner;
use App\Http\Controllers\BadmintonCourt\GetAllBadmintonCourts;
use App\Http\Controllers\BadmintonCourt\GetDetailCourt;
use App\Http\Controllers\BadmintonCourt\ListAcceptBadmintonCourts;
use App\Http\Controllers\BadmintonCourt\MakeSchedule;
use App\Http\Controllers\BadmintonCourt\ShowABadmintonCourt;
use App\Http\Controllers\BadmintonCourt\UpdateBadmintonCourt;
use App\Http\Controllers\Booking\AcceptBooking;
use App\Http\Controllers\Booking\CancelBooking;
use App\Http\Controllers\Booking\CreateBooking;
use App\Http\Controllers\Booking\DeleteBooking;
use App\Http\Controllers\Booking\ListBookingOfOwner;
use App\Http\Controllers\Booking\ListBookingOfUser;
use App\Http\Controllers\Comments\CreateComment;
use App\Http\Controllers\Comments\DeleteComments;
use App\Http\Controllers\Comments\GetComments;
use App\Http\Controllers\Comments\UpdateComments;
use App\Http\Controllers\Favourite\DeleteFavouriteCourt;
use App\Http\Controllers\Favourite\GetFavouriteCourt;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register', [Register::class,'register']);
Route::post('/login', [Login::class,'login']);
Route::get('/auth/google', function () {
    return Socialite::driver('google')->with(["prompt" => "select_account"])->stateless()->redirect();
});
Route::get('/auth/facebook', function () {
    return Socialite::driver('facebook')->with(["prompt" => "select_account"])->stateless()->redirect();
});
Route::get('/auth/{provider}/callbackBE', [Login::class,'loginWithSocialite']);
Route::post('/forgot-password',[ResetPassword::class,'forgotPassword']);
Route::post('/reset-password',[ResetPassword::class,'resetPassword']);
Route::post('/badminton-court',[GetAllBadmintonCourts::class,'getAllBadmintonCourts']);
Route::get("/court-detail/{id}",[GetDetailCourt::class,'getDetailCourt']);
Route::get('/comments/{idBadmintonCourt}',[GetComments::class,'getAllComments']);
Route::post('/badminton-court/empty',[MakeSchedule::class,'badmintonCourtEmptyTime']);

Route::group(['middleware' => 'auth:api'], function () {
    //auth
    Route::post('/logout',[Logout::class,'logout']);

    //account
    Route::get('/list-users', [ListUsers::class,'getAllUsers']);
    Route::post('/create-account',[CreateAccount::class, 'createAccount']);
    Route::get('/account/{id}/edit', [EditAccount::class,'editAccount']);
    Route::get('/account/edit', [EditItsMe::class,'editItsMe']);
    Route::patch('/account/{id}',[UpdateAccount::class,'updateAccount']);
    Route::delete('/account/{id}',[DeleteAccount::class,'deleteAccount']);

    //owner
    Route::get('/owner/booking', [ListBookingOfOwner::class,'listBookingOfOwner']);
    Route::get('/owner/badminton-court',[ShowABadmintonCourt::class,'ShowABadmintonCourt']);
    Route::post('/owner/badminton-court',[CreateBadmintonCourt::class,'CreateBadmintonCourt']);
    Route::get('/owner/badminton-court/{id}/edit',[EditBadmintonCourt::class,'editBadmintonCourt']);
    Route::patch('/owner/badminton-court/{id}',[UpdateBadmintonCourt::class,'updateBadmintonCourt']);
    Route::delete('/owner/badminton-court/{id}',[DeleteBadmintonCourt::class,'deleteBadmintonCourt']);
    Route::get('/owner/list-badminton-courts',[GetAllBadmintonCourtOfOwner::class,'getAllBadmintonCourt']);

    //admin
    Route::get('/accept-badminton-courts/{id}',[AcceptBadmintonCourt::class,'acceptBadmintonCourt']);
    Route::get('/lists-accept/badmintonCourts',[ListAcceptBadmintonCourts::class,'listAcceptBadmintonCourts']);
    Route::get('/admin/all-courts',[AllBadmintonCourts::class,'allBadmintonCourts']);

    //booking
    Route::post('/booking',[CreateBooking::class,'createBooking']);
    Route::patch('/booking/{id}/cancel',[CancelBooking::class,'cancelBooking']);
    Route::delete('/booking/{id}',[DeleteBooking::class,'deleteBooking']);
    Route::patch('/booking/{id}/accept',[AcceptBooking::class,'acceptBooking']);
    Route::get('/list/booking/{idOwner}/{idCourt}', [ListBookingOfUser::class,'listBookingOfUser']);

    Route::post('/badminton-court/schedule',[MakeSchedule::class,'makeSchedule']);

    //comments
    Route::post('/comments/{idBadmintonCourt}',[CreateComment::class,'createComment']);
    Route::patch('/comments/{id}/{idBadmintonCourt}/edit',[UpdateComments::class,'updateComment']);
    Route::delete('/comments/{id}',[DeleteComments::class,'deleteComment']);

    //favouriteCourt
    Route::get('/favourite',[GetFavouriteCourt::class,'getFavouriteCourt']);
    Route::post('/favourite/{idBadmintonCourt}',[GetFavouriteCourt::class,'getFavouriteCourt']);
    Route::delete('/favourite/{id}',[DeleteFavouriteCourt::class,'deleteFavouriteCourt']);
});
