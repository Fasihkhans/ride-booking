<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\VehicleTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::group(['middleware' => ['auth']], function () {
    Route::view('/', 'dashboard')
        ->middleware(['verified'])
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::resource('driver', DriverController::class);
    Route::resource('vehicles', VehiclesController::class);
    Route::resource('vehicle-types', VehicleTypeController::class);
    Route::resource('Booking', BookingController::class);
});

require __DIR__.'/auth.php';