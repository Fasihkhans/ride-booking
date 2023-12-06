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
        switch ($value) {
            case Constants::BOOKING_WAITING:
                $status = 'waiting';
                break;

            case Constants::BOOKING_ACCEPTED:
                $status = 'accepted';
                break;

            case Constants::BOOKING_DECLINED:
                $status = 'declined';
                break;

            case Constants::BOOKING_COMPLETED:
                $status = 'completed';
                break;

            case Constants::BOOKING_IN_PROGRESS:
                $status = 'inProgress';
                break;
            default:
                $status = $value;
                break;
        }

        return $status;
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