<?php

namespace App\Livewire;

use App\Repositories\BookingRepository;
use App\Repositories\DriverRepository;
use App\Repositories\VehiclesRepository;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;


class Dashboard extends Component
{
    public $totalVehicles, $activeVehicles, $activeDrivers, $activeRides, $startDate, $endDate;

    public $labels, $cashDataSet, $cardDataSet, $completedBookings, $uniqueMonths;

    public $gmap;

    public $listeners = ['date-changed'=>'dateChange'];

    public function mount()
    {
        $this->totalVehicles = VehiclesRepository::getAllVehicles()->count();
        $this->activeVehicles = VehiclesRepository::getAllActiveVehicles()->count();
        $this->activeDrivers = DriverRepository::getAllActiveDrivers()->count();
        $this->activeRides = BookingRepository::getActiveBookings()->count();
        $this->startDate = Carbon::now()->previous('year')->startOfYear()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
        $this->getCompletedBookingStats($this->startDate,$this->endDate);
        // $this->labels;
        // $this->startDate = $this->startDate->format('dd-mm-yy');
        // $this->endDate = $this->endDate->format('dd-mm-yy');
    }
    #[On('date-changed')]
    public function dateChange($startDate,$endDate){
        // dd('yes');
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->getCompletedBookingStats($this->startDate,$this->endDate);
    }


    public function getCompletedBookingStats($startDate,$endDate){
        $this->completedBookings = BookingRepository::getCompletedBookingsWithDateRange($startDate,$endDate);
        $this->uniqueMonths = $this->completedBookings->pluck('created_at')->map(function ($date) {
            return $date->format('F Y');
        })->unique();

        $this->labels = $this->uniqueMonths->values()->toArray();

        $this->cashDataSet = array_fill(0, count($this->labels), 0);
        $this->cardDataSet = array_fill(0, count($this->labels), 0);

        $this->completedBookings->each(function ($booking) {
            $monthYear = $booking->created_at->format('F Y');
            $paymentMethod = $booking?->bookingPayment?->paymentMethod?->name;

            $index = array_search($monthYear, $this->labels);

            if ($index !== false) {
                if ($paymentMethod == 'cash') {
                    $this->cashDataSet[$index]++;
                } elseif ($paymentMethod == 'card') {
                    $this->cardDataSet[$index]++;
                }
            }
        });
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}