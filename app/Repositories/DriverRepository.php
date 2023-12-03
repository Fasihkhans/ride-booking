<?php

namespace App\Repositories;

use App\Models\Driver;
use App\Interfaces\IDriverRepository;

class DriverRepository implements IDriverRepository
{
    static public function create(array $data)
    {
        return Driver::create($data);
    }

    public function update(Driver $driver,array $data)
    {
        $driver->license_no = $data['license_no'];
        $driver->license_expiry = $data['license_expiry'];
        return $driver->save();
    }
}
