<?php

namespace App\Repositories;

use App\Models\VehicleUploads;
use App\Interfaces\IVehicleUploadsRepository;

class VehicleUploadsRepository implements IVehicleUploadsRepository
{
    static public function create(array $data)
    {
        return VehicleUploads::create($data);
    }
}