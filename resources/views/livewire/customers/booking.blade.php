<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Session;
use App\Repositories\CustomerPaymentMethodsRepository;
use App\Models\CustomerPaymentMethods;
use App\Repositories\VehicleTypesRepository;
use TeamPickr\DistanceMatrix\DistanceMatrix as DistanceMatrixDistanceMatrix;
use TeamPickr\DistanceMatrix\Licenses\StandardLicense;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Repositories\BookingRepository;
use Illuminate\Support\Facades\Auth;

new
#[Layout('layouts.customer')]
class extends Component
{
    use WithPagination;

    public $booking;

    public $origin;

    public $destination;

    public $totalCost;

    public $paymentMethodId;

    public $paymentMethods;

    public string $statusMessage;

    public $count = 0;

    // function state(['statusMessage'])

    public function updateStatus($status)
    {
        // $this->mount();
        switch ($status) {
            case 'waiting':
                $this->statusMessage = 'Waiting for rider approval';
            break;
            case 'accepted':
                $this->statusMessage = 'Your rider is on the way';
            break;

            case 'inProgress':
                $this->statusMessage = 'Your ride has start';
            break;

            case 'completed':
                $this->statusMessage = 'Ride complete';
            break;

            default:
                $this->statusMessage = 'Your rider is on the way';
        }
        // $this->statusMessage = 'Your rider is on the way';
        // dd($data);
        // $this->render();

    }

    #[On('cancelRide')]
    public function cancelRide()
    {
        bookingRepository::updateBookingStatus('cancelByUser', $this->booking->id);
        $this->redirect(route('customer-home'),navigate: true);
    }

    public function rate()
    {
        $this->redirect(route('customer-home'),navigate: true);
    }

    public function getListeners()
    {
        return [
            "booking.".$this->booking->id => 'updateStatus',
        ];
    }

    function mount()
    {
        // $this->paymentMethods = CustomerPaymentMethods::Where('user_id',Auth::user()->id)->get();
        $this->booking = BookingRepository::findCustomerActiveBookings(Auth::user()->id);
        if(!$this->booking){
            $this->redirect(route('customer-home'),navigate: true);
        }else{
            foreach($this->booking->bookingStops as $bookingStop)
            {
                if($bookingStop->type == 'pickUp'){
                    $this->origin = (object) ['latitude' => $bookingStop->latitude,'longitude' => $bookingStop->longitude,'stop'=>$bookingStop->stop];
                }elseif ($bookingStop->type == 'dropOff') {
                    $this->destination = (object) ['latitude' => $bookingStop->latitude,'longitude' => $bookingStop->longitude,'stop'=>$bookingStop->stop];
                }
            }
            $this->updateStatus($this->booking->status);
        }

    }

}
?>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    <div>
        {{-- {{ dd(json_decode($paymentMethods[0]->stripe_card_reference)->token->card->last4) }} --}}

            <x-gmap class="w-screen min-h-screen" :origin="$origin" :destination="$destination"></x-gmap>
            <x-booking-card>
            {{-- <input type="text" wire:model='count'> --}}
            <x-back-button :url="route('customer-home')"></x-back-button>
            <div class="flex justify-center w-full p-2 bg-black rounded-lg">
                <p class="text-lg font-bold text-white status-message" >{{ $statusMessage }}</p>
            </div>
            <div class="flex items-center mt-4">
              <img class="mr-4 rounded-full h-14 w-14" src="{{ asset('assets/svg/user-avatar.svg') }}" alt="Rider Avatar">
              <div>
                <div class="font-semibold text-gray-800">{{ $booking->driver->user->first_name." ".$booking->driver->user->last_name }}</div>
                <div class="flex items-center gap-1">
                    <div id="rating-container" class="flex">
                        <!-- Star 1 -->
                        <svg class="w-6 h-6 star" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path class="star-fill" d="M5.60022 17.2675L6.69652 12.2787L6.75849 11.9967L6.54522 11.8021L2.84083 8.42142L7.712 7.97632L8.01655 7.94849L8.1305 7.6647L9.99984 3.00892L11.8692 7.6647L11.9831 7.94849L12.2877 7.97632L17.1588 8.42142L13.4545 11.8021L13.2412 11.9967L13.3032 12.2787L14.3995 17.2675L10.2679 14.644L9.99984 14.4738L9.73181 14.644L5.60022 17.2675Z" stroke="#303030"/>
                        </svg>
                        <svg class="w-6 h-6 star" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="star-fill" d="M5.60022 17.2675L6.69652 12.2787L6.75849 11.9967L6.54522 11.8021L2.84083 8.42142L7.712 7.97632L8.01655 7.94849L8.1305 7.6647L9.99984 3.00892L11.8692 7.6647L11.9831 7.94849L12.2877 7.97632L17.1588 8.42142L13.4545 11.8021L13.2412 11.9967L13.3032 12.2787L14.3995 17.2675L10.2679 14.644L9.99984 14.4738L9.73181 14.644L5.60022 17.2675Z" stroke="#303030"/>
                        </svg>

                        <svg class="w-6 h-6 star" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="star-fill" d="M5.60022 17.2675L6.69652 12.2787L6.75849 11.9967L6.54522 11.8021L2.84083 8.42142L7.712 7.97632L8.01655 7.94849L8.1305 7.6647L9.99984 3.00892L11.8692 7.6647L11.9831 7.94849L12.2877 7.97632L17.1588 8.42142L13.4545 11.8021L13.2412 11.9967L13.3032 12.2787L14.3995 17.2675L10.2679 14.644L9.99984 14.4738L9.73181 14.644L5.60022 17.2675Z" stroke="#303030"/>
                        </svg>
                        <svg class="w-6 h-6 star" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="star-fill" d="M5.60022 17.2675L6.69652 12.2787L6.75849 11.9967L6.54522 11.8021L2.84083 8.42142L7.712 7.97632L8.01655 7.94849L8.1305 7.6647L9.99984 3.00892L11.8692 7.6647L11.9831 7.94849L12.2877 7.97632L17.1588 8.42142L13.4545 11.8021L13.2412 11.9967L13.3032 12.2787L14.3995 17.2675L10.2679 14.644L9.99984 14.4738L9.73181 14.644L5.60022 17.2675Z" stroke="#303030"/>
                        </svg>
                        <svg class="w-6 h-6 star" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="star-fill" d="M5.60022 17.2675L6.69652 12.2787L6.75849 11.9967L6.54522 11.8021L2.84083 8.42142L7.712 7.97632L8.01655 7.94849L8.1305 7.6647L9.99984 3.00892L11.8692 7.6647L11.9831 7.94849L12.2877 7.97632L17.1588 8.42142L13.4545 11.8021L13.2412 11.9967L13.3032 12.2787L14.3995 17.2675L10.2679 14.644L9.99984 14.4738L9.73181 14.644L5.60022 17.2675Z" stroke="#303030"/>
                        </svg>
                        <!-- ... repeat for other stars, ensuring each has a unique class or id ... -->
                    </div>

                  <span class="text-lg text-gray-600">{{ $booking->driver->user->aggregate_rating }}</span>
                </div>
              </div>
              {{-- <button class="p-2 ml-auto bg-gray-100 rounded-full">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6 text-gray-600"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.55 4.55a1 1 0 01-1.42 1.42L15 11.42V17a1 1 0 01-2 0v-5.58l-3.13 3.13a1 1 0 01-1.42-1.42L13 10V3a1 1 0 012 0v7z"></path></svg>
              </button> --}}
            </div>
            <div class="m-4 space-y-2">

                <div class="inline-flex">
                    <img src="{{ asset('assets/svg/destination-pointer.svg') }}" class="w-4 h-4 mr-2 rotate-180 bg-black rounded-full invert">
                    <div class="text-base text-gray-600">{{ $origin->stop }}</div>
                </div>
                <div class="w-px h-8 mx-2 bg-gray-300" style="border-left: 2px dashed;"></div>
                <div class="inline-flex">
                    <img src="{{ asset('assets/svg/origin-pointer.svg') }}" class="w-4 h-4 mr-2 bg-black rounded-full invert">
                    <div class="text-base text-gray-600 ">{{ $destination->stop }}</div>
                </div>
              <!-- ... other address items ... -->
            </div>
            <div class="flex justify-between w-full gap-1 mt-4 booking-action">
              <button wire:click='cancelRide' id="cancel" class="px-4 py-2 text-black bg-white border border-black rounded-lg">Cancel</button>
              <a href="tel:{{ $booking->driver->user->phone_number }}" class="w-full">
                <button class="w-full px-4 py-2 text-center text-white bg-black border rounded-lg">Call</button>
                </a>
            </div>

            <div class="flex justify-between w-full gap-1 mt-4 rate-action">
                <a href="{{route('rating',['booking'=>Crypt::encrypt($booking->id)])}}" class="w-full">
                  <button wire:click='rate' class="w-full px-4 py-2 text-center text-white bg-black border rounded-lg">Rate</button>
                  </a>
            </div>

        </x-booking-card>
        {{-- @script --}}
        <script src="https://cdn.socket.io/4.7.5/socket.io.min.js" integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous"></script>
        {{-- @endscript --}}
    {{-- @script --}}
    <script>
        $(document).ready(function() {
            $('#cancel').click(function() {
                $wire.dispatch('cancelRide');
            });
            $('.rate-action').css('display', 'none');
        });

        const rating = {{ $booking->driver->user->aggregate_rating }};
        const stars = document.querySelectorAll('.star .star-fill');

        stars.forEach((star, index) => {
            if (index < rating) {
            star.setAttribute('fill', 'yellow');
            } else {
            star.setAttribute('fill', 'none');
            }
        });
        const bookingId = "{{ $booking->id }}";
        document.addEventListener('DOMContentLoaded', function() {
            const tryConnectSocket = function(attempts) {
                if (attempts <= 0) {
                    console.error('Failed to connect to the socket after several attempts.');
                    return;
                }
                const socket = io('https://dartscars.com:8443');

                socket.on('connect', () => {
                    console.log('Socket connected successfully');
                    setupBookingChannel(socket);
                });

                socket.on('connect_error', (error) => {
                    console.error('Connection failed, retrying...', error);
                    setTimeout(() => tryConnectSocket(attempts - 1), 5000); // Retry after 5 seconds
                });
            };

            const setupBookingChannel = function(socket) {
                socket.on(`booking.${bookingId}`, function(data) {
                    console.log('listening', data);
                    updateStatus(data.bookingData.status);
                });
            };

            const updateStatus = function(status) {
                const statusMessage = document.querySelector('.status-message');
                switch(status) {
                    case 'waiting':
                        statusMessage.innerHTML = 'Waiting for rider approval';
                        break;
                    case 'accepted':
                        statusMessage.innerHTML = 'Your rider is on the way';
                        break;
                    case 'inProgress':
                        statusMessage.innerHTML = 'Your ride has start';
                        break;
                    case 'completed':
                        statusMessage.innerHTML = 'Ride complete';
                        document.querySelectorAll('.rate-action').forEach(element => element.style.display = 'block');
                        document.querySelectorAll('.booking-action').forEach(element => element.style.display = 'none');
                        break;
                    default:
                        statusMessage.innerHTML = 'Your rider is on the way';
                }
            };

            tryConnectSocket(5); // Try to connect up to 5 times
        });

    </script>
    {{-- @endscript --}}
    @style
    <style>
        .star .star-fill {
          stroke: #303030;
          stroke-width: 1.5; /* You can adjust the stroke-width as needed */
        }
        .filled {
          fill: yellow; /* This color will be applied when the star is filled */
        }
      </style>
    @endstyle
    </div>
