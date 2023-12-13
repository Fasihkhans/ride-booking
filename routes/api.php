<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\DriverController;
use App\Http\Controllers\Api\V1\VehicleTypesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

    // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //     return $request->user();
    // });
    Route::middleware('auth:api')->group(function () {

        Route::post('user/logout', [AuthController::class, 'logout']);

        Route::get('pricing/list',[VehicleTypesController::class, 'list']);

        Route::middleware('role:user')->prefix('user')->group(function(){


            Route::post('booking',[BookingController::class, 'store']);

            Route::get('latest/stops', [BookingController::class, 'latestStops']);

            Route::patch('stop/{id}', [BookingController::class, 'favouriteStop']);

            Route::get('booking',[BookingController::class, 'currentBooking']);

            Route::patch('booking/status',[BookingController::class, 'currentBookingStatus']);

        });
        Route::middleware('role:driver')->prefix('driver')->group(function () {

            Route::get('booking',[BookingController::class, 'currentBooking']);

            Route::patch('booking/status',[BookingController::class, 'currentBookingStatus']);

            Route::patch('status',[DriverController::class, 'updateStatus']);

        });
    });

    Route::post('user/signup', [AuthController::class, 'signup']);
    Route::post('user/login', [AuthController::class, 'login']);

    Route::post('account/otp/send', [AuthController::class, 'send']);
    Route::post('account/otp/verify', [AuthController::class, 'verify']);
    // Route::post('user/oauth/login', [OAuthController::class, 'login']);