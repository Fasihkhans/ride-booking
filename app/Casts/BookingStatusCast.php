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
        return $value;
    }

}
