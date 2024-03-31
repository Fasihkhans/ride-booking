<?php

use function Livewire\Volt\{state};
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Http;
// use Exception;
use App\Constants\Constants;
// use App\Repositories\BookingRepository;
use App\Repositories\BookingPaymentsRepository;
use App\Repositories\BookingRepository;
use App\Repositories\BookingStopsRepository;
use Illuminate\Support\Facades\Auth;

new #[Layout('layouts.customer')] class extends Component
{
    #[Url]
    public $booking;

    #[Url]
    public $paymentMethodId;

    #[Url]
    public $preCalculatedFare;

    public $status;

    #[On('next')]
    public function next($routeName)
    {
        $this->redirect(route($routeName),navigate: true);

    }

    public function mount(){
        $this->interval();
    }

    public function interval(){
        $this->data = $this->createBooking();
    }

    public function createBooking()
    {

            // Retrieve values, decrypting if available, or using session as fallback
            $dropOff = $this->booking ? Crypt::decrypt($this->booking[0]) : Session::get('dropOff');
            $pickUp = $this->booking ? Crypt::decrypt($this->booking[1]) : Session::get('pickUp');
            $paymentMethodId = $this->paymentMethodId ? Crypt::decrypt($this->paymentMethodId) : Session::get('paymentMethodId');
            $preCalculatedFare = $this->preCalculatedFare ? Crypt::decrypt($this->preCalculatedFare) : Session::get('preCalculatedFare');

            $booking = BookingRepository::create(['customer_id'=>Auth::user()->id,
                                                        'status'=>'waiting',
                                                        'type'=>Constants::BOOKING_TYPE_ON_DEMAND,
                                                        'pre_calculated_fare'=>$preCalculatedFare
                                                    ]);
            $data = [
                $pickUp,
                $dropOff
            ];
            foreach($data as $bookingStop)
            {
                $bookingStop['booking_id'] = $booking->id;
                $bookingStop['status'] = Constants::BOOKING_STOP_STATUS_ACTIVE;
                BookingStopsRepository::create($bookingStop);
            }
            $bookingRepository = new BookingRepository;
            $bookingRepository->createBookingPayment($booking->id,$paymentMethodId);
            $bookingWithStops = BookingRepository::findWithStops($booking->id);
            $this->status =$bookingWithStops->status;

    }

}

?>
<div>
    <x-booking-gmap></x-booking-gmap>
    <div class="absolute inset-0 z-50 flex items-center justify-center w-full h-full bg-gray-900 opacity-50">
        <div class="flex items-center justify-center w-32 h-32 bg-yellow-300 rounded-full opacity-75 animate-pulse-fast">
            <div class="w-24 h-24 bg-yellow-400 rounded-full opacity-80"></div>
        </div>
    </div>
    <!-- Yellow pulsing circle -->
    <div class="absolute flex items-center justify-center">

    </div>
    <x-booking-card class="bd-black">
        <x-back-button :url="route('pickup')"></x-back-button>
            <div class="p-4 text-black rounded opacity-75">
                <p class="text-xl font-semibold status">Finding your driver ...</p>

            </div>

    </x-booking-card>
    @script
    <script>
        const element = document.querySelector('.animate-pulse-fast');

        element.style.animation = 'pulse 1.5s infinite cubic-bezier(0.4, 0, 0.6, 1)';
        const status = document.querySelector('.status');
        setTimeout(() => {
            let  action = '{{ $status }}'
            switch(action){
                case 'noDriverFound':
                    status.textContent = "Opss! No driver available right now. Please try again or contact the admin.";
                    setTimeout(() => {
                        $wire.dispatch('next',{routeName: 'customer-home'});
                    }, 1000);
                break;
                case 'waiting':
                        $wire.dispatch('next',{routeName: 'current-booking'});
                break;
                default:
                    $wire.dispatch('next',{routeName: 'customer-home'});
            }

        }, 3000);
    </script>
    @endscript
    @style
    <style>
        @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(100%);
        }
        50% {
            opacity: .5;
            transform: scale(200%);
        }
        }
    </style>
    @endstyle
</div>
