<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VehicleAssignmentController;
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

Route::view('/', 'welcome')->name('welcome');
Route::view('/privacy-policy', 'website.privacy-policy');
Route::view('/help', 'website.help');
Route::post('help', [HelpController::class, 'sendMail'])->name('helpMail');

Route::middleware(['auth','role:admin'])->prefix('admin')->group( function () {
    Route::view('/', 'dashboard')
        ->middleware(['verified'])->name('dashboard');

    Route::view('profile', 'profile')->name('profile');

    Route::resource('driver', DriverController::class);
    Route::get('/driver-csv-download',[DriverController::class, 'exportCSV'])->name('download.driver.csv');
    Route::resource('vehicles', VehiclesController::class);
    Route::get('/vehicles-csv-download',[VehiclesController::class, 'exportCSV'])->name('download.vehicles.csv');
    Route::resource('vehicle-types', VehicleTypeController::class);
    Route::resource('booking', BookingController::class);
    Route::get('/booking-csv-download',[BookingController::class, 'exportCSV'])->name('download.booking.csv');
    Route::resource('vehicle-assignment', VehicleAssignmentController::class);
    Route::get('/vehicle-assignment-csv-download',[VehicleAssignmentController::class, 'exportCSV'])->name('download.vehicle-assignment.csv');
    Route::resource('users', UsersController::class);
    Route::get('/users-csv-download',[UsersController::class, 'exportCSV'])->name('download.users.csv');
});

require __DIR__.'/auth.php';
