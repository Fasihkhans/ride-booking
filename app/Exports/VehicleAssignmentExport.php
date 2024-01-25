<?php

namespace App\Exports;

use App\Models\DriverVehicles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleAssignmentExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DriverVehicles::select([
            'users.first_name',
            'vehicles.license_no_plate',
            'driver_vehicles.start_date',
            'driver_vehicles.start_time',
            'driver_vehicles.end_date',
            'driver_vehicles.end_time',
            'driver_vehicles.status',
        ])
        ->orderBy('driver_vehicles.created_at', 'desc')
        ->join('drivers', 'driver_vehicles.driver_id', '=', 'drivers.id')
        ->join('users', 'drivers.user_id', '=', 'users.id')
        ->join('vehicles', 'driver_vehicles.vehicle_id', '=', 'vehicles.id')
        ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Driver',
            'Vehicle',
            'Start Date',
            'Time',
            'end Date',
            'Time',
            'Status',
            // 'Vehicle Column',
            // 'Booking Column',
        ];
    }
}