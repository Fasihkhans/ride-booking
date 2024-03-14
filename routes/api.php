<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\DriverController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\UserRatingController;
use App\Http\Controllers\Api\V1\VehicleTypesController;
use App\Http\Controllers\Api\V1\UsersController;
use App\Jobs\SendFcmNotification;
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

            Route::get('{id}/bookings',[BookingController::class, 'list']);

            Route::get('{id}/booking/{bookingId}',[BookingController::class, 'get']);

            Route::patch('{id}/booking/{bookingId}/status',[BookingController::class, 'bookingStatus']);

            Route::get('{id}/currentbooking',[BookingController::class, 'currentBooking']);

            Route::delete('{id}',[UsersController::class, 'destroy']);

            Route::post('{id}/payment-method',[PaymentController::class, 'store']);

            Route::get('{id}/payment-methods',[PaymentController::class, 'list']);

            Route::delete('{id}/payment-method/{methodId}',[PaymentController::class, 'destory']);

            Route::patch('{id}/payment-method/{methodId}/default',[PaymentController::class, 'default']);

        });
        Route::middleware('role:driver')->prefix('driver')->group(function () {

            Route::get('{id}/currentbooking',[BookingController::class, 'currentBooking']);

            Route::get('{id}/bookings',[BookingController::class, 'list']);

            Route::get('{id}/booking/{bookingId}',[BookingController::class, 'get']);

            Route::patch('{id}/booking/{bookingId}/status',[BookingController::class, 'bookingStatus']);

            Route::patch('{id}/online',[DriverController::class, 'onlineStatus']);

            Route::patch('{id}/booking/{bookingId}/payment-confirmation',[BookingController::class, 'paymentStatus']);

            Route::get('{id}/online',[DriverController::class, 'isOnline']);

            Route::get('{id}/income',[DriverController::class,'getIncome']);

        });

        Route::post('rating',[UserRatingController::class,'store']);

    });
    Route::post('push-notification', function (Request $request) {
        $deviceToken = $request->input('device_token');
        $title = $request->input('title');
        $body = $request->input('body');

        dispatch(new SendFcmNotification($deviceToken, $title, $body));

        return response()->json(['message' => 'Push notification dispatched successfully'], 200);
    });

    Route::post('user/signup', [AuthController::class, 'signup']);
    Route::post('user/login', [AuthController::class, 'login']);

    Route::post('account/otp/send', [AuthController::class, 'send']);
    Route::post('account/otp/verify', [AuthController::class, 'verify']);



    // Route::get('/socket.io', function (Request $request) {
    //     return app('Laravel\EchoServer\Server')->handle($request);
    // });
    // Route::post('user/oauth/login', [OAuthController::class, 'login']);
