<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_fare' ,
        'per_mintue_rate' ,
        'per_mile_rate' ,
        'min_mintues' ,
        'min_miles' ,
        'holiday_rate' ,
        'peak_hour_rate' ,
        'upload_url',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicles::class);
    }
}