<?php

namespace App\Casts;

use App\Constants\Constants;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class UserStatusCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return match ($value) {
            Constants::ACTIVE => 'active',
            Constants::ACTIVE_DRIVER_ON_BREAK => 'inActive',
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
            'active' => Constants::ACTIVE,
            'inActive' => Constants::ACTIVE_DRIVER_ON_BREAK,
            default => 00, // Assuming you have a constant for 'unknownStatus'
        };
    }
}
