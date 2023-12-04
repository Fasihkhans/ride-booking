<?php

namespace App\Interfaces;

use App\Models\Vehicles;

interface IVehiclesRepository
{
    static public function create(array $data);

    public function update(Vehicles $vehicles,array $data);

}