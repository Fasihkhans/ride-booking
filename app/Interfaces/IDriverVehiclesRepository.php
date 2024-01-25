<?php

namespace App\Interfaces;

use App\Models\DriverVehicles;

interface IDriverVehiclesRepository
{
    static public function create(array $data);

    static public function getActive();

    static public function update(DriverVehicles $driver,array $data);

    /**
     * Fetch data from the DriverVehicle model based on a given id.
     *
     * @param int $id
     * @return object
     */
    static public function findById(int $id);

}
