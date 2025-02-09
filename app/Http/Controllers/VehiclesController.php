<?php

namespace App\Http\Controllers;

use App\Exports\VehiclesExport;
use App\Http\Requests\StoreVehiclesRequest;
use App\Http\Requests\UpdateVehiclesRequest;
use App\Models\Vehicles;
use Maatwebsite\Excel\Facades\Excel;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("vehicles.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("vehicles.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehiclesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view("vehicles.show",['id'=>$id]);
    }

     /**
     * export vehicle data in CSV format
     */
    public function exportCSV(){
        return Excel::download(new VehiclesExport, 'vehicles.csv');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicles $vehicles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehiclesRequest $request, Vehicles $vehicles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicles $vehicles)
    {
        //
    }
}