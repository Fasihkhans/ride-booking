<div class="bg-white">

    <dl class="grid items-center justify-center w-full max-w-screen-xl grid-cols-4 gap-8 p-4 mx-auto text-gray-900 dark:text-white sm:p-8">
        <x-stats-card :title="'Total Vehicles'">
            {{ str_pad($totalVehicles, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
        <x-stats-card :title="'Active Vehicles'">
            {{ str_pad($activeVehicles, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
        <x-stats-card :title="'Active Drivers'">
            {{ str_pad($activeDrivers, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
        <x-stats-card :title="'Active Rides'">
            {{ str_pad($activeRides, 2, '0', STR_PAD_LEFT) }}
        </x-stats-card>
    </dl>
    <section class="p-4 m-4 border shadow rounded-xl">
        <div class="flex items-center justify-between">
            <h2 class="col-6"> Trends</h2>
            <div class=" col-4">
                {{-- <div  id="reportrange" class="justify-center p-2 border rounded-sm cursor-pointer min-w-min max-w-max justify-self-end"  >
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div> --}}
                {{-- <x-date-picker :startDate="$startDate" :endDate="$endDate"></x-date-picker> --}}
            </div>
        </div>
        <div class="container w-full p-4 mx-auto">
            {{-- <canvas id="stackedChart" width="800" height="400"></canvas> --}}
            <x-stack-graph :labels="$labels" :cashDataSet="$cashDataSet" :cardDataSet="$cardDataSet"  wire:poll="$labels"></x-stack-graph>
        </div>
    </section>
    <section class="p-4 m-4 border shadow-sm rounded-xl">
        <h2> Current Trips</h2>
        <div id="maps" class="w-full p-10 h-96 rounded-xl "></div>
        {{-- <x-live-gmap></x-live-gmap> --}}
    </section>

    @assets

    {{-- <script src="https://cdn.jsdelivr.net/npm/livewire/livewire.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    @endassets
    @script
    <script>
        $(document).ready(function () {
            $(function() {

                function cb(start, end) {

                    var start = moment(start ).isValid() ? moment(start) : moment().subtract(29, 'days');
                    var end = moment(end).isValid() ? moment(end) : moment();
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    // setLocalStorage(start, end); // Store the selected date range
                }
                cb(@json($startDate), @json($endDate));
                $('#reportrange').daterangepicker({
                    startDate: {{ $startDate}},
                    endDate: {{ $endDate}},
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb);

                $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                    const startDate = picker.startDate.format('YYYY-MM-DD');
                    const endDate = picker.endDate.format('YYYY-MM-DD');
                    $wire.dispatch('date-changed',{startDate: picker.startDate, endDate: picker.endDate})
                    cb(picker.startDate, picker.endDate);
                });
            });
        });
    </script>
    @endscript
    @script
    <script>
        (async () => {
            const liveMapApiKey = "{{ env('GOOGLE_MAPS_KEY') }}";
            const liveMapStyle = [
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
                let script = document.createElement('script');
                script.src = `https://maps.googleapis.com/maps/api/js?key=${liveMapApiKey}&libraries=places&callback=initMaps`;
                script.defer = true;
                script.async = true;

                // Set up a callback function to initialize the map once the script is loaded
                window.initMaps = async () => {
                    let { maps } = google; // Destructure the 'maps' object

                    // Apply the custom style to the map
                    let map = new maps.Map(document.getElementById('maps'), {
                        center: { lat: 54.532497, lng: -1.5605716 },
                        zoom: 13,
                        styles: liveMapStyle, // Apply the custom style here
                        gestureHandling: "none",
                    });
                };

                // Append the script to the document
                document.head.appendChild(script);
            } else {
                // If the Google Maps API is already loaded, initialize the map directly
                await initMaps();
            }
        });
    </script>
    @endscript
</div>
