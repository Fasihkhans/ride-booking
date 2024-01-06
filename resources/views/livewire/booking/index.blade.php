<div>
    <dl class="grid items-center justify-center w-full max-w-screen-xl grid-cols-3 gap-6 mx-auto text-gray-900 dark:text-white sm:py-8">
        <x-stats-card :title="'Active Trips'">
            {{ str_pad($activeTrips, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
        <x-stats-card :title="'Total Trips Today'">
            {{  str_pad($todayTrips, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
        <x-stats-card :title="'Total Receipts'">
            £ {{ str_pad($totalReceipts, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
    </dl>
    <section class="py-4">
        <h2> Current Trips</h2>
        <div id="map" class="w-full py-4 h-80 rounded-xl "></div>
    </section>
    <div>
        {{-- <form class="flex items-center" wire:submit="search">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input wire:model='query' type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
            </div>
        </form> --}}

    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-2">
                        Number
                    </th>
                    <th scope="col" class="p-2">
                        Start time
                    </th>
                    <th scope="col" class="p-2">
                        End time
                    </th>
                    <th scope="col" class="p-2">
                        Pickup
                    </th>
                    <th scope="col" class="p-2">
                        Drop off
                    </th>
                    <th scope="col" class="p-2">
                        Est. Time
                    </th>

                    <th scope="col" class="p-2">
                        Driver
                    </th>
                    <th scope="col" class="p-2">
                        Est. Amount
                    </th>
                    <th scope="col" class="p-2">
                        Actual Amount
                    </th>
                    <th scope="col" class="p-2">
                        Type
                    </th>
                    <th scope="col" class="p-2">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $booking )
                {{-- <tr class="bg-white border-b cursor-pointer dark:bg-gray-800 dark:border-gray-700" onclick="window.location.href='{{ route('',encrypt($booking->id)) }}';"> --}}
                    <tr class="bg-white border-b cursor-pointer dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $booking->vehicle?->license_no_plate }}
                        </th>
                        <td class="p-2">
                            {{ $booking->created_at->format('d M Y h:i a') }}
                        </td>
                        <td class="p-2">
                            {{ $booking->updated_at->format('d M Y h:i a') }}
                            {{-- <img src="{{Storage::disk(env('CURRENT_IMG_DRIVER'))->url($bookingType->upload_url) }}"/> --}}
                        </td>
                        <td class="p-2">
                            {{ $booking->bookingStops?->first()->stop }}
                        </td>
                        <td class="p-2">
                            {{ $booking->bookingStops?->last()->stop  }}
                        </td>

                        <td class="p-2">
                            {{ $booking->bookingPayment?->total_minutes }}
                        </td>

                        <td class="p-2">
                            {{ $booking->driver?->first_name." ".$booking->driver?->last_name }}
                        </td>

                        <td class="p-2">
                            {{ $booking->pre_calculated_fare }}
                        </td>
                        <td class="p-2">
                            {{ $booking->bookingPayment?->total_fare }}
                        </td>
                        <td class="p-2">
                            {{ $booking->bookingPayment?->paymentMethod?->name }}
                        </td>
                        <td class="p-2">
                            <span class="{{ ($booking->status=='completed')?'bg-green-100 text-emerald-900':'bg-rose-100 text-red-800' }} p-1 rounded-md">
                            {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">
        {{ $data->links()}}
    </div>

    @script
      <script>
        (async () => {
            const apiKey = "{{ env('GOOGLE_MAPS_KEY') }}";
            const style = [
                            {
                                "elementType": "geometry",
                                "stylers": [
                                {
                                    "color": "#212121"
                                }
                                ]
                            },
                            {
                                "elementType": "labels.icon",
                                "stylers": [
                                {
                                    "visibility": "off"
                                }
                                ]
                            },
                            {
                                "elementType": "labels.text.fill",
                                "stylers": [
                                {
                                    "color": "#757575"
                                }
                                ]
                            },
                            {
                                "elementType": "labels.text.stroke",
                                "stylers": [
                                {
                                    "color": "#212121"
                                }
                                ]
                            },
                            {
                                "featureType": "administrative",
                                "elementType": "geometry",
                                "stylers": [
                                {
                                    "color": "#757575"
                                }
                                ]
                            },
                            {
                                "featureType": "administrative.country",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                {
                                    "color": "#9e9e9e"
                                }
                                ]
                            },
                            {
                                "featureType": "administrative.land_parcel",
                                "stylers": [
                                {
                                    "visibility": "off"
                                }
                                ]
                            },
                            {
                                "featureType": "administrative.locality",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                {
                                    "color": "#bdbdbd"
                                }
                                ]
                            },
                            {
                                "featureType": "poi",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                {
                                    "color": "#757575"
                                }
                                ]
                            },
                            {
                                "featureType": "poi.park",
                                "elementType": "geometry",
                                "stylers": [
                                {
                                    "color": "#181818"
                                }
                                ]
                            },
                            {
                                "featureType": "poi.park",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                {
                                    "color": "#616161"
                                }
                                ]
                            },
                            {
                                "featureType": "poi.park",
                                "elementType": "labels.text.stroke",
                                "stylers": [
                                {
                                    "color": "#1b1b1b"
                                }
                                ]
                            },
                            {
                                "featureType": "road",
                                "elementType": "geometry.fill",
                                "stylers": [
                                {
                                    "color": "#2c2c2c"
                                }
                                ]
                            },
                            {
                                "featureType": "road",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                {
                                    "color": "#8a8a8a"
                                }
                                ]
                            },
                            {
                                "featureType": "road.arterial",
                                "elementType": "geometry",
                                "stylers": [
                                {
                                    "color": "#373737"
                                }
                                ]
                            },
                            {
                                "featureType": "road.highway",
                                "elementType": "geometry",
                                "stylers": [
                                {
                                    "color": "#3c3c3c"
                                }
                                ]
                            },
                            {
                                "featureType": "road.highway.controlled_access",
                                "elementType": "geometry",
                                "stylers": [
                                {
                                    "color": "#4e4e4e"
                                }
                                ]
                            },
                            {
                                "featureType": "road.local",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                {
                                    "color": "#616161"
                                }
                                ]
                            },
                            {
                                "featureType": "transit",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                {
                                    "color": "#757575"
                                }
                                ]
                            },
                            {
                                "featureType": "water",
                                "elementType": "geometry",
                                "stylers": [
                                {
                                    "color": "#000000"
                                }
                                ]
                            },
                            {
                                "featureType": "water",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                {
                                    "color": "#3d3d3d"
                                }
                                ]
                            }
                            ];
           // Check if the Google Maps API script has already been loaded
           if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                // Load the Google Maps API script dynamically
                const script = document.createElement('script');
                script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places&callback=initMap`;
                script.defer = true;
                script.async = true;

                // Set up a callback function to initialize the map once the script is loaded
                window.initMap = async () => {
                    const { maps } = google; // Destructure the 'maps' object

                    // Apply the custom style to the map
                    const map = new maps.Map(document.getElementById('map'), {
                        center: { lat: 54.532497, lng: -1.5605716 },
                        zoom: 13,
                        styles: style, // Apply the custom style here
                        gestureHandling: "none",
                        // marker
                    });
                };

                // Append the script to the document
                document.head.appendChild(script);
            } else {
                // If the Google Maps API is already loaded, initialize the map directly
                await initMap();
            }
        })();
    </script>
    @endscript
</div>
