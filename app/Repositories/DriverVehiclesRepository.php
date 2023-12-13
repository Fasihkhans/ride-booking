<?php

namespace App\Repositories;

use App\Constants\Constants;
use App\Models\DriverVehicles;
use App\Interfaces\IDriverVehiclesRepository;

class DriverVehiclesRepository implements IDriverVehiclesRepository
{
    static public function create(array $data)
    {
        return DriverVehicles::create($data);
    }

    static public function getActive()
    {
        return DriverVehicles::where('status', Constants::ACTIVE)->get();
    }
    public function update(DriverVehicles $driver,array $data)
    {

    }
}