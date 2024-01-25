<?php

namespace App\Http\Controllers;

use App\Exports\BookingsExport;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use Maatwebsite\Excel\Facades\Excel;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("bookings.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('bookings.show',['id'=>$id]);
    }


     /**
     * export vehicle data in CSV format
     */
    public function exportCSV(){
        return Excel::download(new BookingsExport, 'trips.csv');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $bookings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $bookings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $bookings)
    {
        //
    }
}