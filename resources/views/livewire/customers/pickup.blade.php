<?php

use function Livewire\Volt\{state};
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\Attributes\Url;
use App\Repositories\BookingRepository;
use Illuminate\Support\Facades\Session;

new #[Layout('layouts.customer')] class extends Component
{
    public $origin = '';
    #[Url]
    public $booking;

    public function mount(){
        if(BookingRepository::findCustomerActiveBookings(Auth::user()->id)){
            $this->redirect(route('current-booking'),navigate: true);
        }
    }
    public function pickUp()
    {
        // Crypt::decrypt($this->booking[0]);
        $pickUp = Session::get('pickUp');
        if($pickUp){

            $this->redirect(
                route('payment', ['booking' => [$this->booking[0],Crypt::encrypt($pickUp)]]),
                    navigate: true
                );
        }
    }
}
?>

<div>
    <x-booking-gmap></x-booking-gmap>
    <x-booking-card>
        <x-back-button :url="route('customer-home')"></x-back-button>
        <form wire:submit="pickUp">
            <p class="text-xl font-extrabold">Pickup</p>
            <div class="flex items-center mt-2 border border-gray-300 rounded-md focus:border-blue-50">
                <!-- Where to input field -->
                <div class="flex-1 ">
                    <div class="relative">
                        <!-- Pin location marker -->
                        <div class="absolute top-0 left-0 mt-2.5 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 2.5a4.5 4.5 0 0 1 4.5 4.5c0 2.474-2.441 5.266-4.154 7.24a1 1 0 0 1-1.692 0C7.941 12.266 5.5 9.974 5.5 7a4.5 4.5 0 0 1 4.5-4.5zM10 11a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <livewire:customers.components.places-autocomplete type="pickUp" place_holder=" Enter your destination"/>

                    </div>
                </div>

                <!-- Dropdown for Now or Later -->
            </div>
            <x-input-error :messages="$errors->get('destination')" class="mt-2" />
            <div class="flex items-center justify-center mt-4">

                <x-primary-button class="flex items-center justify-center w-full text-white capitalize rounded-[1.8rem] bg-zinc-800 hover:text-black">
                    {{ __('Confirm Pickup') }}
                </x-primary-button>
            </div>
        </form>
    </x-booking-card>

</div>
