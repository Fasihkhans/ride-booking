<?php

use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\PaymentController as PaymentViewController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VehicleAssignmentController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\VehicleTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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
Route::get('testsockets', function (Request $request) {
    // Get the bookingID query parameter from the request
    $bookingId = $request->query('bookingId');

    // Pass the bookingId variable to the view
    return view('checking-websocket', [
        'bookingId' => $bookingId
    ]);
});

Route::view('/', 'welcome')->name('welcome');
Route::view('/privacy-policy', 'website.privacy-policy');
Route::view('/help', 'website.help');
Route::post('help', [HelpController::class, 'sendMail'])->name('helpMail');


Route::middleware(['auth','role:admin'])->prefix('admin')->group( function () {


    // Route::get('payment-details',[PaymentViewController::class, 'index'])->name('payment-details');


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

Route::middleware(['auth','role:user'])->prefix('user')->group( function () {
    Volt::route('/payment-details', 'payment-details');
    Route::post('save-card', [PaymentViewController::class,'store'])->name('save-card');
});
require __DIR__.'/auth.php';


Route::get('fire', function () {
    // this fires the event
    event(new App\Events\TestEvent());
    return "event fired";
});

Route::get('test', function () {
    return view('test');
});


Route::middleware(['auth','role:user'])->prefix('user')->group( function () {
    Volt::route('/', 'customers.index')->name('customer-home');
    Volt::route('/pickup', 'customers.pickup')->name('pickup');
    Volt::route('/payment', 'customers.payment')->name('payment');
    Volt::route('/addcard', 'customers.addcard')->name('addcard');
    Volt::route('/finding-driver', 'customers.finding-driver')->name('finding-driver');
    Volt::route('/booking', 'customers.booking')->name('current-booking');
    Volt::route('/rating', 'customers.rating')->name('rating');
    Route::view('/profile', 'user-profile')->name('user-profile');

});
