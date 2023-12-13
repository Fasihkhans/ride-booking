<?php

namespace App\Interfaces;

use App\Models\Driver;

interface IDriverRepository
{
    static public function create(array $data);

    static public function getAllActiveDrivers();

    static public function UpdateStatus(string $status,int $id);
    public function update(Driver $driver,array $data);

}
