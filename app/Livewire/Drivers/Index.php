<?php

namespace App\Livewire\Drivers;

use App\Models\Driver;
use Illuminate\Support\Facades\DB;
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
        $data = Driver::whereHas('user',function ($query) {
            $query->whereRaw('first_name like ?', ['%' . $this->query . '%'])
                  ->orWhereRaw('last_name like ?', ['%' . $this->query . '%']);
        })
        ->with(['user','driverVehicles.vehicle','booking'])
        ->paginate(10);
        return view('livewire.drivers.index',['data'=>$data]);
    }

}