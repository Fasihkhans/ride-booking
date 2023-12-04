<?php

namespace App\Interfaces;

use App\Models\VehicleType;

interface IVehicleTypesRepository
{
    static public function create(array $data);

    public function update(VehicleType $type,array $data);

    static public function getAll();
}