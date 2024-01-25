<?php

namespace App\Http\Controllers;

use App\Exports\DriverExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("drivers.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("drivers.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        return view("livewire.drivers.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // dd(decrypt($id));
        return view("drivers.show",['id'=>$id]);
    }

    /**
     * export driver data in CSV format
     */
    public function exportCSV(){
            return Excel::download(new DriverExport, 'drivers.csv');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}