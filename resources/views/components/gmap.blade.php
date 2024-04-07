<div>
    <div id="map" {{ $attributes->merge(['class' => 'w-full py-4 h-80 rounded-xl']) }}></div>
    @script
      <script>
        (function () {
            function initMap() {
                    const { maps } = google; // Destructure the 'maps' object

                    // Create a DirectionsService and DirectionsRenderer
                    const directionsService = new maps.DirectionsService();
                    const directionsRenderer = new maps.DirectionsRenderer({
                        suppressMarkers: true,
                        polylineOptions: {
                            strokeColor: '#FFB800',
                        },
                    });
                    // Apply the custom style to the map
                    const map = new maps.Map(document.getElementById('map'), {
                        // center: { lat: 54.532497, lng: -1.5605716 },
                        zoom: 13,
                        styles: style, // Apply the custom style here
                        gestureHandling: "none",
                        // origin: '5 Greener Dr, Darlington DL1 5JP, UK',
                        // destination: 'Victoria Rd, Darlington DL1 5JJ, United Kingdom',
                        // travelMode: 'DRIVING',
                        // // marker
                    });


                        // Set up the origin and destination for directions
                    const origin = @json([$origin->latitude,$origin->longitude]).toString();
                    const destination = @json([$destination->latitude,$destination  ->longitude]).toString();

                    const originMarker = new maps.Marker({
                        position: { lat: @json($origin->latitude), lng: @json($origin->longitude) }, // Replace with the actual coordinates of the origin
                        map: map,
                        title: 'Origin',
                        icon: @json(asset('assets/svg/origin-pointer.svg')).toString(), // Replace with the path to your custom marker image for the origin
                    });

                    const destinationMarker = new maps.Marker({
                        position: { lat: @json($destination->latitude), lng: @json($destination->longitude) }, // Replace with the actual coordinates of the destination
                        map: map,
                        title: 'Destination',
                        icon: @json(asset('assets/svg/destination-pointer.svg')).toString(), // Replace with the path to your custom marker image for the destination
                    });
                    // Request directions from the DirectionsService
                    directionsService.route(
                        {
                            origin: origin,
                            destination: destination,
                            travelMode: 'DRIVING',
                        },
                        (response, status) => {
                            if (status === 'OK') {
                                // Display the directions on the map using DirectionsRenderer
                                directionsRenderer.setDirections(response);
                                directionsRenderer.setMap(map);
                            } else {
                                console.error('Directions request failed:', status);
                            }
                        }
                    );
                };

            console.log(@json([$destination->latitude,$origin->longitude]).toString());
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

            if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                // Load the Google Maps API script dynamically
                const script = document.createElement('script');
                script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}`;//&callback=initMap&libraries=places`;
                script.defer = true;
                script.async = true;

                script.onload = () => {
                    // Once the script is loaded, call the initMap function

                            initMap();


                };

                script.onerror = () => {
                    console.error('Failed to load Google Maps API script.');
                };

                // Append the script to the document
                document.head.appendChild(script);
            } else {
                // If the Google Maps API is already loaded, directly call the initMap function

                    initMap();
            }
           // Check if the Google Maps API script has already been loaded
        })();
    </script>
    @endscript
</div>
