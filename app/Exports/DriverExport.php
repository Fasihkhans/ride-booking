<?php

namespace App\Exports;

use App\Models\Driver;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DriverExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Driver::select([
            'drivers.*',
            'users.first_name',
            'users.last_name',
        ])
        ->orderBy('drivers.created_at', 'desc')
        ->Join('users', 'drivers.user_id', '=', 'users.id')
        ->leftJoin('driver_vehicles', 'drivers.id', '=', 'driver_vehicles.driver_id')
        ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'User ID',
            'License No',
            'License Expiry',
            'License Img Url',
            'Created At',
            'Updated At',
            'Is Online',
            'First Name',
            'Last Name',
            // 'Vehicle Column',
            // 'Booking Column',
        ];
    }
}