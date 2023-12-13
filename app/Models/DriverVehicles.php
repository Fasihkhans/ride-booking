<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverVehicles extends Model
{
    use HasFactory;

    protected $fillable = [
        "driver_id",
        "vehicle_id",
        "start_time",
        "end_time",
        "start_date",
        "end_date",
        "status",
    ];

    protected $casts = [
        "start_time" => "datetime",
        "end_time" => "datetime"
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicles::class);
    }
}
