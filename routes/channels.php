<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::routes(['middleware' => ['auth:api']]);

Broadcast::channel('booking.{bookingId}', function (User $user, $bookingId) {
    return true;
});

Broadcast::channel('driver.{driverId}', function (User $user, $driverId) {
    return true;
});

Broadcast::channel('driver-booking.{driverId}', function (User $user, $driverId) {
    return true;
});
