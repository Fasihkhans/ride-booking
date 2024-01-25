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

    /**
     * Fetch data from the DriverVehicle model based on a given id.
     *
     * @param int $id
     * @return object
     */
    static public function findById(int $id)
    {
        return DriverVehicles::find($id);
    }
    static public function update(DriverVehicles $driverVehicles,array $data)
    {
        $driverVehicles->start_date = $data['start_date'];
        $driverVehicles->end_date = $data['end_date'];
        $driverVehicles->start_time = $data['start_time'];
        $driverVehicles->end_time = $data['end_time'];
        $driverVehicles->driver_id = $data['driver_id'];
        $driverVehicles->vehicle_id = $data['vehicle_id'];
        $driverVehicles->status = $data['status'];
        $driverVehicles->save();
        return $driverVehicles;
    }
}
