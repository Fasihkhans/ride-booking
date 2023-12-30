<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicles;
use App\Repositories\VehiclesRepository;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $query = '';

    public $totalVehicles, $activeVehicles, $inActiveVehicles;

    public function mount()
    {
        $this->totalVehicles = VehiclesRepository::getAllVehicles()->count();
        $this->activeVehicles = VehiclesRepository::getAllActiveVehicles()->count();
        $this->inActiveVehicles = $this->totalVehicles - $this->activeVehicles;
    }

    public function search()
    {
        $this->resetPage();
    }
    public function render()
    {
        $data = Vehicles::where('license_no_plate', 'like', '%'.$this->query.'%')->with(['vehicleType'])->paginate(10);
        return view('livewire.vehicles.index',['data'=>$data]);
    }
}