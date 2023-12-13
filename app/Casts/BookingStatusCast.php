<?php

namespace App\Casts;

use App\Constants\Constants;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class BookingStatusCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return match ($value) {
            Constants::BOOKING_WAITING => 'waiting',
            Constants::BOOKING_ACCEPTED => 'accepted',
            Constants::BOOKING_DECLINED => 'declined',
            Constants::BOOKING_COMPLETED => 'completed',
            Constants::BOOKING_IN_PROGRESS => 'inProgress',
            Constants::BOOKING_NO_DRIVER_FOUND => 'noDriverFound',
            Constants::BOOKING_CANCEL_BY_USER => 'cancelByUser',
            default => 'unknownStatus',
        };
    }


    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return match ($value) {
            'waiting' => Constants::BOOKING_WAITING,
            'accepted' => Constants::BOOKING_ACCEPTED,
            'declined' => Constants::BOOKING_DECLINED,
            'completed' => Constants::BOOKING_COMPLETED,
            'inProgress' => Constants::BOOKING_IN_PROGRESS,
            'noDriverFound' => Constants::BOOKING_NO_DRIVER_FOUND,
            'cancelByUser' => Constants::BOOKING_CANCEL_BY_USER,
            default => 00, // Assuming you have a constant for 'unknownStatus'
        };
    }

}
