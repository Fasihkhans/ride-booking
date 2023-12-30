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
        return match ((int) $value) {
            Constants::ACTIVE => 'active',
            Constants::INACTIVE => 'inActive',
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
            'inActive' => Constants::INACTIVE,
            default => 00, // Assuming you have a constant for 'unknownStatus'
        };
    }
}