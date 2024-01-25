<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("vehicle-assignment.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("vehicle-assignment.create");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show(string $id)
    {
        return view("vehicle-assignment.show",['id'=>$id]);
    }

}