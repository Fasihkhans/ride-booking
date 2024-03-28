<?php

namespace App\Livewire\Customers\Components;

use App\Repositories\BookingStopsRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
class LatestStops extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortBy = 'created_at';
    public $stops;

    public function mount()
    {
        $this->loadMore();
    }

    public function loadMore()
    {
        $stops = BookingStopsRepository::findLatestStops(Auth::user()->id)
            ->paginate($this->perPage);
            // dd($stops);

        if ($this->stops) {
            // $this->stops->items = $this->stops->items->concat($stops->items);
            // $this->stops->links = $stops->links;
        } else {
            $this->stops = $stops;
        }
    }

    public function render()
    {
        return view('livewire.customers.components.latest-stops');
    }
}
