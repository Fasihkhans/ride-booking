<?php

namespace App\Livewire\VehicleAssignment;

use App\Models\DriverVehicles;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $query = '';

    public function search()
    {
        $this->resetPage();
    }
    public function render()
    {
        $data = DriverVehicles::whereHas('driver.user',function ($query) {
            $query->whereRaw('first_name like ?', ['%' . $this->query . '%'])
                  ->orWhereRaw('last_name like ?', ['%' . $this->query . '%']);
        })
        ->with(['driver.user','vehicle'])
        ->paginate(10);
        return view('livewire.vehicle-assignment.index',['data'=>$data]);
    }

}