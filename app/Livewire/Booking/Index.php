<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\Vehicles;
use App\Repositories\BookingRepository;
use App\Repositories\VehiclesRepository;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $query = '';

    public $activeTrips, $todayTrips, $totalReceipts;

    public function mount()
    {
        $this->activeTrips = BookingRepository::getActiveBookings()->count();
        // dd(now()->today());
        $this->todayTrips = BookingRepository::getAllBookingDateWise(now()->today())->count();
        $this->totalReceipts = BookingRepository::getCompletedBookings()->sum('pre_calculated_fare');
    }

    public function search()
    {
        $this->resetPage();
    }
    public function render()
    {
        $data = Booking::with('bookingStops','driver','vehicle','bookingPayment')->paginate(10);
        return view('livewire.booking.index',['data'=>$data]);
    }
}