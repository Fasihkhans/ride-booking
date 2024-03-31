<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Session;
use App\Models\CustomerPaymentMethods;
use App\Repositories\UserRatingRepository;
use App\Repositories\UserRepository;
use TeamPickr\DistanceMatrix\DistanceMatrix as DistanceMatrixDistanceMatrix;
use TeamPickr\DistanceMatrix\Licenses\StandardLicense;
use Carbon\Carbon;
use Livewire\Attributes\On;
use App\Repositories\BookingRepository;
use Illuminate\Support\Facades\Auth;

new
#[Layout('layouts.customer')]
class extends Component
{

    #[Url]
    public $booking;

    public $bookings;

    public $origin;

    public $destination;

    function mount()
    {

        if(!$this->booking){
            $this->redirect(route('customer-home'),navigate: true);
        }else{
            $this->bookings = bookingRepository::findBooking((int) Crypt::decrypt($this->booking));
            foreach($this->bookings->bookingStops as $bookingStop)
            {
                if($bookingStop->type == 'pickUp'){
                    $this->origin = (object) ['latitude' => $bookingStop->latitude,'longitude' => $bookingStop->longitude,'stop'=>$bookingStop->stop];
                }elseif ($bookingStop->type == 'dropOff') {
                    $this->destination = (object) ['latitude' => $bookingStop->latitude,'longitude' => $bookingStop->longitude,'stop'=>$bookingStop->stop];
                }
            }
        }

    }

    #[On('reviews')]
    public function review($data)
    {
        // dd($data);
        $userRatingRepository = new UserRatingRepository();
        $userRatingRepository->create([
            'user_id' => auth()->id(),
            'booking_id' => $this->bookings->id,
            'rating' => $data['rating'],
            'review' => $data['review'] ?? null,
        ]);
        $avgRating = $userRatingRepository->getUserAverageRating(auth()->id());
        $userRepository = new UserRepository();
        $userRepository->updateAggregateRating($avgRating, auth()->id());
        $this->redirect(route('customer-home'),navigate: true);
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
            <div class="flex items-center justify-center mt-4">
              <img class="w-20 h-20 rounded-full" src="{{ asset('assets/svg/user-avatar.svg') }}" alt="Rider Avatar">
            </div>
            <div class="flex items-center justify-center mt-4">

                <div class="font-semibold text-center text-gray-800 ">{{ $bookings->driver->user->first_name." ".$bookings->driver->user->last_name }}</div>
            </div>
            <div class="flex items-center justify-center mt-4">
                <div class="flex items-center gap-1">
                    <div id="rating-container" class="flex">
                        <div class="star-rating">
                            <button class="star" data-rating="1">&#9733;</button>
                            <button class="star" data-rating="2">&#9733;</button>
                            <button class="star" data-rating="3">&#9733;</button>
                            <button class="star" data-rating="4">&#9733;</button>
                            <button class="star" data-rating="5">&#9733;</button>
                        </div>
                        <input type="hidden" id="rating" name="rating" value="0">
                    </div>
                </div>
            </div>
              {{-- <button class="p-2 ml-auto bg-gray-100 rounded-full">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6 text-gray-600"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.55 4.55a1 1 0 01-1.42 1.42L15 11.42V17a1 1 0 01-2 0v-5.58l-3.13 3.13a1 1 0 01-1.42-1.42L13 10V3a1 1 0 012 0v7z"></path></svg>
              </button> --}}

            <div class="m-4 space-y-2">
                <textarea id="review-text"></textarea>
              <!-- ... other address items ... -->
            </div>

            <div class="flex justify-between w-full gap-1 mt-4">

                  <button id="submit-review"  class="w-full px-4 py-2 text-center text-white bg-black border rounded-lg">Submit Review</button>
            </div>

        </x-booking-card>
    @script
    <script>

$(document).ready(function() {
    // Selecting stars
    const stars = $('.star');
    const ratingInput = $('#rating');
    const reviewInput = $('#review-text');

    // Click event on each star
    stars.click(function() {
        const rating = parseInt($(this).data('rating'));
        ratingInput.val(rating); // Update the hidden input value

        // Update stars display based on clicked star
        stars.each(function(index) {
            if (index < rating) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
    });

    $('#submit-review').click(function() {
        const ratingValue = ratingInput.val();
        $wire.dispatch('reviews', {data:{rating: ratingValue, review: reviewInput.val()}});
    });
});



    </script>
    @endscript

    <style>
        .star {
            font-size: 25px;
            color: gray;
            background: none;
            border: none;
            cursor: pointer;
        }

        .star:hover, .star.active {
            color: gold;
        }
    </style>
    </div>
