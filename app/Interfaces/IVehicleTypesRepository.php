<?php

namespace App\Interfaces;

use App\Models\VehicleType;

interface IVehicleTypesRepository
{
    static public function create(array $data);

    public function update(VehicleType $type,array $data);

    static public function getAll();

    /**
     * Fetch data from the VehicleType model based on a search query.
     *
     * @param string|null $search
     * @return
     */
    static public function fetchData(string $search);

    /**
     * Fetch data from the VehicleType model based on a given id.
     *
     * @param int $id
     * @return object
     */
    static public function findById(int $id);

    /**
     * Fetch data from the VehicleType model based on a given name.
     *
     * @param int $id
     * @return object
     */
    static public function getVehicleByName(string $name);

    static public function list();
}