<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_type_id',
        'license_no_plate',
        'make',
        'model',
        'year',
        'color',
        'max_capacity',
        'status',
    ];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class,'vehicle_type_id');
    }

    public function vehicleUploads()
    {
        return $this->hasMany(VehicleUploads::class);
    }

    public function vehicleBookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function driverVehicles()
    {
        return $this->hasMany(DriverVehicles::class);
    }
}