<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleTypeRequest;
use App\Http\Requests\UpdateVehicleTypeRequest;
use App\Interfaces\IVehicleTypesRepository;
use App\Models\VehicleType;

class VehicleTypeController extends Controller
{
    public function __construct(private IVehicleTypesRepository $VehicleTypesRepository)
    {

    }

    /**
     *  Display a listing of the resource.
     */
    public function index()
    {
        // $vehicleTypes = $this->VehicleTypesRepository::fetchData('')->paginate(10);
        // return view('livewire.vehicle-types.index', ['vehicleTypes' => $vehicleTypes]);
        return view("vehicle-types.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("vehicle-types.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleTypeRequest $request, VehicleType $vehicleType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleType $vehicleType)
    {
        //
    }
}