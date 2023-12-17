<?php

namespace App\Livewire\VehicleTypes;

use App\Models\VehicleType;
use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\VehicleTypesRepository;

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
        $data = VehicleType::where('name', 'like', '%'.$this->query.'%')->paginate(10);
        return view('livewire.vehicle-types.index',['data'=>$data]);
    }

}