<?php

namespace App\Interfaces;

use App\Models\DriverVehicles;

interface IDriverVehiclesRepository
{
    static public function create(array $data);

    static public function getActive();

    public function update(DriverVehicles $driver,array $data);

}
