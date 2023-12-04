<?php

namespace App\Interfaces;

use App\Models\VehicleUploads;

interface IVehicleUploadsRepository
{
    static public function create(array $data);

}