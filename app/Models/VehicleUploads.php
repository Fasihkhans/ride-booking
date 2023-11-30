<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleUploads extends Model
{
    use HasFactory;

    protected $fillable = [
        "vehicle_id",
        "upload_url",
        "upload_type"
    ];

    public function vehicles()
    {
        return $this->belongsTo(vehicles::class);
    }
}
