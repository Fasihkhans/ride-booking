<?php

namespace App\Livewire\Users;

use App\Models\User;
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
        $data = User::where('role_id',2)
        ->where('verified',true)
        ->where(function ($query) {
            $query->whereRaw('first_name like ?', ['%' . $this->query . '%'])
                  ->orWhereRaw('last_name like ?', ['%' . $this->query . '%'])
                  ->orWhereRaw('email like ?', ['%' . $this->query . '%']);
        })
        ->paginate(10);
        return view('livewire.users.index',['data'=>$data]);
    }
}