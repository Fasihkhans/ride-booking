<?php

use function Livewire\Volt\{state};
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Session;

new #[Layout('layouts.customer')] class extends Component
{
    public $destination = '';
    public $dropOff;
    public function mount(){
        $this->dropOff = Session::get('dropOff');
    }

    public function destinations()
    {
        $this->dropOff = Session::get('dropOff');
        if($this->dropOff){
            $this->redirect(
                route('pickup', ['booking' => [Crypt::encrypt($this->dropOff)]]),
                    navigate: true
                );
        }
    }
    public function hydrate(){
        $this->dropOff = Session::get('dropOff');
    }


}

?>

<div>
    <x-booking-gmap></x-booking-gmap>
    <x-booking-card>

            <p class="text-xl font-extrabold">Where to</p>
            <div class="inline-flex items-center mt-2 border border-gray-300 rounded-md focus:border-blue-50">
                <!-- Where to input field -->
                <div class="flex-1 ">
                    <div class="relative">
                        <!-- Pin location marker -->
                        <div class="absolute top-0 left-0 mt-2.5 mr-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-black" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 2.5a4.5 4.5 0 0 1 4.5 4.5c0 2.474-2.441 5.266-4.154 7.24a1 1 0 0 1-1.692 0C7.941 12.266 5.5 9.974 5.5 7a4.5 4.5 0 0 1 4.5-4.5zM10 11a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <livewire:customers.components.places-autocomplete type="dropOff" place_holder=" Enter your destination"/>
                        {{-- <input type="text" placeholder=" Where to" class="w-full px-4 py-2 focus:outline-none focus:border-blue-500" wire:model='destination'> --}}

                    </div>
                </div>

                <!-- Dropdown for Now or Later -->
                <div>
                    <select class="px-2 py-2 pr-6 text-sm focus:outline-none focus:border-blue-500">
                        <option value="now">Now</option>
                        <option value="later">Later</option>
                    </select>
                </div>
            </div>
            {{-- <livewire:customers.components.latest-stops> --}}
            <div class="flex items-center justify-center mt-4">

                <x-primary-button  wire:click='destinations'  class="flex items-center justify-center w-full text-white capitalize rounded-[1.8rem] bg-zinc-800 hover:text-black">
                    {{ __('Select destination') }}
                </x-primary-button>
            </div>
    </x-booking-card>

</div>
