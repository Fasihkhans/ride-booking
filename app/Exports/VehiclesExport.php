<?php

namespace App\Exports;

use App\Models\Vehicles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehiclesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Vehicles::select([
            'license_no_plate',
            'vehicles.created_at',
            'make',
            'model',
            'year',
            'color',
            'vehicle_types.name',
            'status',
        ])
        ->orderBy('vehicles.created_at', 'desc')
        ->Join('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.id')
        ->get();
    }


    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Number',
            'Date Added',
            'Make',
            'Model',
            'Year',
            'Color',
            'Type',
            'Status',
            // 'Vehicle Column',
            // 'Booking Column',
        ];
    }
}
