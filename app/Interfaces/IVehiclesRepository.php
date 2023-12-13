<?php

namespace App\Interfaces;

use App\Models\Vehicles;

interface IVehiclesRepository
{
    static public function create(array $data);

    static public function getAllActiveVehicles();

    public function update(Vehicles $vehicles,array $data);

}