
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

use function Livewire\Volt\{state,with,usesPagination,layout,mount};

new #[Layout('layouts.customer')] class extends Component
{
    use WithPagination;

    #[Url]
    public $booking;

    public $origin;

    public $destination;

    public $totalCost;

    public $paymentMethodId;

    public $paymentMethods;

    #[On('confirm')]
    public function confirm($paymentMethodId)
    {

        Session::put("paymentMethodId", $paymentMethodId);
        Session::put("preCalculatedFare", $this->totalCost);
        $this->redirect(route('finding-driver',['booking'=>$this->booking,
                                                'paymentMethodId'=>Crypt::encrypt($paymentMethodId),
                                                'preCalculatedFare'=>Crypt::encrypt($this->totalCost)
                                                ]),
                        navigate: true);

    }

    function mount()
    {
        if(BookingRepository::findCustomerActiveBookings(Auth::user()->id)){
            $this->redirect(route('current-booking'),navigate: true);
        }
        $this->paymentMethods = CustomerPaymentMethods::Where('user_id',Auth::user()->id)->get();
        $dropOff = $this->booking?Crypt::decrypt($this->booking[0]):Session::get('dropOff');
        $pickUp = $this->booking?Crypt::decrypt($this->booking[1]):Session::get('pickUp');
        $this->destination = (object) ['latitude' => $dropOff['latitude'],'longitude' => $dropOff['longitude']];
        $this->origin = (object) ['latitude' => $pickUp['latitude'],'longitude' => $pickUp['longitude']];
        $bookingTime = Carbon::now();
        $vehicleType = VehicleTypesRepository::getVehicleByName('saloon');
        $dayStartTime = Carbon::createFromTime(6, 0, 0); // 06:00:00
        $dayEndTime = Carbon::createFromTime(22, 0, 0);  // 22:00:00
        if ($bookingTime->between($dayStartTime, $dayEndTime)) {
            $baseFare = $vehicleType?->base_fare;
        } else {
            $baseFare = $vehicleType?->night_base_fare;
        }
        // dd($baseFare);
        $perMinuteRate = $vehicleType?->per_minute_rate;
        $perMileRate = $vehicleType?->per_mile_rate;
        $peakHourRate = $vehicleType?->peak_hour_rate;
        $holidayRate = $vehicleType?->holiday_rate;

        $totalMinutes = $startTime?->diffInMinutes($endTime)?? 0;

        $license = new StandardLicense(env('GOOGLE_MAPS_KEY'));
        $getDistance = DistanceMatrixDistanceMatrix::license($license)
                        ->addOrigin($this->origin->latitude.','.$this->origin->longitude)
                        ->addDestination($this->destination->latitude.','.$this->destination->longitude)->useMetricUnits()
                        ->request();
        $totalMeters = 0;
        $count = 0;
        foreach($getDistance->rows() as $distance)
        {
            $totalMeters += $distance->elements()[$count]->distance();
            $count++;
        }
        $totalMiles = round($totalMeters*0.00062137,1);
        $this->totalCost = $baseFare + ($perMinuteRate * $totalMinutes)+($perMileRate * $totalMiles);

    }

}
?>





    <div>
        {{-- {{ dd(json_decode($paymentMethods[1]->stripe_card_reference)->token->card->brand) }} --}}

            <x-gmap class="w-screen min-h-screen" :origin="$origin" :destination="$destination"></x-gmap>
        <x-booking-card>
            <x-back-button :url="route('pickup')"></x-back-button>

                <p class="text-xl font-extrabold">Select Payment Option</p>
                <div class="flex justify-between">
                    <div class="float-left text-lg font-extrabold">Fare</div>
                    <div class="float-right pl-4 text-lg">£ {{ $totalCost }}</div>
                </div>
                <div class="flex items-center mt-2 border border-gray-300 rounded-md focus:border-blue-50">
                    <div class="flex-1">
                        <div class="relative">
                            <select id="paymentMethodSelect" class="w-full px-4 py-2 text-sm focus:outline-none focus:border-blue-500">
                                @foreach ($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod->id }}"
                                        data-image="{{ asset($paymentMethod->name == 'cash' ? 'assets/svg/cash-icon.svg' : 'assets/svg/'.json_decode($paymentMethod->stripe_card_reference)->token->card->brand.'-icon.svg') }}"
                                        class="inline-flex justify-between">
                                        @if ($paymentMethod->name == 'cash' || $paymentMethod->name == 'card')
                                            <img src="{{ asset($paymentMethod->name == 'cash' ? 'assets/svg/cash-icon.svg' : 'assets/svg/'.json_decode($paymentMethod->stripe_card_reference)->token->card->brand.'-icon.svg') }}" />
                                        @endif
                                        @if ($paymentMethod->name == 'cash')
                                            <p class="float-right">{{ $paymentMethod->name }}</p>
                                        @elseif ($paymentMethod->name == 'card')
                                            <p class="items-center float-right">xxxx-xxxx-xxxx-{{ json_decode($paymentMethod->stripe_card_reference)->token->card->last4 }}</p>
                                        @endif
                                    </option>

                                @endforeach
                                <option value="add_card" class="content-center" data-image="{{ asset('assets/svg/Add.svg') }}" ><a href="{{ route('addcard') }}"><img src="{{ asset('assets/svg/Add.svg') }}" />Add card</a></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <x-primary-button  id="confirm" class="flex items-center justify-center w-full text-white capitalize rounded-[1.8rem] bg-zinc-800 hover:text-black">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
        </x-booking-card>

    @script
    <script>
        $(document).ready(function() {
            $('#confirm').click(function() {
                var paymentMethodId = $('#paymentMethodSelect').val();
                $wire.dispatch('confirm', { paymentMethodId: paymentMethodId });
            });
            $('#paymentMethodSelect').select2({
                templateResult: formatOption,
                escapeMarkup: function(markup) {
                    return markup;
                }
            }).on('select2:select', function (e) {
                var data = e.params.data;
                if (data.id === 'add_card') {
                    window.location.href = '{{ route('addcard') }}'; // Navigate to the add card URL
                    return; // Prevent further execution
                }
                var imageUrl = $(data.element).data('image');
                var $selectedOption = $('#paymentMethodSelect').next().find('.select2-selection__rendered');
                var $selectedImage = $('<img src="' + imageUrl + '" class="inline w-5 h-5 mr-2"/>');
                $selectedOption.prepend($selectedImage);
            }).on('select2:unselect', function (e) {
                var $selectedOption = $('#paymentMethodSelect').next().find('.select2-selection__rendered');
                $selectedOption.find('img').remove();
            });
        });

        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }
            // Check if the option is "Add card" by value or text
            if (option.id === 'add_card' || option.text === 'Add card') {
                return $('<span class="flex w-full justify-content"><img src="' + $(option.element).data('image') + '" class="w-5 h-5 mr-2 img-option" /> <p class="items-center float-right">' + option.text + '</span>');
            }
            var $option = $(
                '<span class="flex items-center"><img src="' + $(option.element).data('image') + '" class="w-5 h-5 mr-2 img-option" /> <p class="items-center float-right">' + option.text + '</p></span>'
            );

            return $option;
        }
    </script>
    @endscript
    </div>
