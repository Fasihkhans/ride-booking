<?php

namespace App\Livewire;

use App\Repositories\BookingRepository;
use App\Repositories\DriverRepository;
use App\Repositories\VehiclesRepository;

use Livewire\Component;

class Dashboard extends Component
{
    public $totalVehicles, $activeVehicles, $activeDrivers, $activeRides;

    public $gmap;

    public function mount()
    {
        $this->totalVehicles = VehiclesRepository::getAllVehicles()->count();
        $this->activeVehicles = VehiclesRepository::getAllActiveVehicles()->count();
        $this->activeDrivers = DriverRepository::getAllActiveDrivers()->count();
        $this->activeRides = BookingRepository::getActiveBookings()->count();
        $this->gmap = $this->googleMaps();

    }

    public function googleMaps()
    {
        return [
            [
                'position' => [
                    'lat' => 28.625485,
                    'lng' => 79.821091
                ],
                'label' => [ 'color' => 'white', 'text' => 'P1' ],
                'draggable' => true
            ],
            [
                'position' => [
                    'lat' => 28.625293,
                    'lng' => 79.817926
                ],
                'label' => [ 'color' => 'white', 'text' => 'P2' ],
                'draggable' => false
            ],
            [
                'position' => [
                    'lat' => 28.625182,
                    'lng' => 79.81464
                ],
                'label' => [ 'color' => 'white', 'text' => 'P3' ],
                'draggable' => true
            ]
        ];

    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}