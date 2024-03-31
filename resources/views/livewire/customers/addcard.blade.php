<?php

use function Livewire\Volt\{state};
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Session;

new #[Layout('layouts.customer')] class extends Component
{

}

?>

<div>
    <x-booking-gmap></x-booking-gmap>
    <x-booking-card>

            <p class="text-xl font-extrabold">Add card detail</p>
            <x-stripe-card></x-stripe-card>
            <div class="inline-flex items-center mt-2 border border-gray-300 rounded-md focus:border-blue-50">
                <div class="flex-1 ">
                    <div class="relative">



                    </div>
                </div>
            </div>
    </x-booking-card>

</div>
