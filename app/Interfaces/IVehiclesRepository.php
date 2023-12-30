<?php

namespace App\Interfaces;

use App\Models\Vehicles;

interface IVehiclesRepository
{
    static public function create(array $data);

    static public function getAllActiveVehicles();

    static public function getAllVehicles();

    public function update(Vehicles $vehicles,array $data);

}