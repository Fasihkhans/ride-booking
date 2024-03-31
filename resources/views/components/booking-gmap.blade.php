<div>
    <div id="maps" class="w-screen min-h-screen"></div>
    <button class="absolute z-50 w-10 h-10 bg-white border cursor-pointer top-16 right-2" id="recenter-button"><img src="{{ asset('assets/svg/recenter.svg') }}"/></button>

    @script
    <script>

        (function () {
            function initMap() {
                // Apply the custom style to the map
                const map = new google.maps.Map(document.getElementById('maps'), {
                    center: { lat: 54.532497, lng: -1.5605716 },
                    zoom: 13,
                    styles: style,
                    // gestureHandling: "none",
                    fullscreenControl: false,
                    mapTypeControl: false,
                    streetViewControl: false,
                });

                // Add click event listener to the map
                google.maps.event.addListener(map, 'click', function(event) {
                    placeMarker(event.latLng, map);
                    $wire.dispatch('marker-latlng',{'latlng':event.latLng})
                });

                // Function to place a marker at a specific location
                function placeMarker(location, map) {
                    // Remove existing marker (if any)
                    if (window.marker) {
                        window.marker.setMap(null);
                    }
                    // Create a new marker
                    window.marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        icon: @json(asset('assets/svg/marker.svg')).toString(),
                    });
                }

                const recenterButton = document.getElementById('recenter-button');
                recenterButton.addEventListener('click', function() {
                    // Get user's current location
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            const userLocation = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };
                            // Reposition map to the user's current location
                            map.setCenter(userLocation);
                            $wire.dispatch('marker-latlng',{'latlng':userLocation})
                            // Reposition marker to the user's current location
                            placeMarker(userLocation, map);
                        }, function() {
                            alert('Error: The Geolocation service failed.');
                        });
                    } else {
                        alert('Error: Your browser does not support Geolocation.');
                    }
                });

                $wire.on('marker-location', ($data) => {
                    console.log($data[0].location);
                    map.setCenter($data[0].location);
                    placeMarker($data[0].location, map);

                });
                    //=============================make
                $wire.on('make-direction', (data) => {
                    console.log(data[0]);

                    // const directionsService = new maps.DirectionsService();
                    // const directionsRenderer = new maps.DirectionsRenderer({
                    //     suppressMarkers: true,
                    //     polylineOptions: {
                    //         strokeColor: '#FFB800',
                    //     },
                    // });

                    // // Set up the origin and destination for directions
                    // const origin = [data.origin.latitude, data.origin.longitude].toString();
                    // const destination = [data.destination.latitude, data.destination.longitude].toString();

                    // const originMarker = new maps.Marker({
                    //     position: { lat: data.origin.latitude, lng: data.origin.longitude },
                    //     map: map,
                    //     title: 'Origin',
                    //     icon: @json(asset('assets/svg/origin-pointer.svg')).toString(),
                    // });

                    // const destinationMarker = new maps.Marker({
                    //     position: { lat: data.destination.latitude, lng: data.destination.longitude },
                    //     map: map,
                    //     title: 'Destination',
                    //     icon: @json(asset('assets/svg/destination-pointer.svg')).toString(),
                    // });

                    // // Request directions from the DirectionsService
                    // directionsService.route({
                    //     origin: origin,
                    //     destination: destination,
                    //     travelMode: 'DRIVING',
                    // }, (response, status) => {
                    //     if (status === 'OK') {
                    //         // Display the directions on the map using DirectionsRenderer
                    //         directionsRenderer.setDirections(response);
                    //         directionsRenderer.setMap(map);
                    //     } else {
                    //         console.error('Directions request failed:', status);
                    //     }
                    // });
                });

            }
            const apiKey = "AIzaSyAK7e1i54SmdDqdhLDsK4PvkgveKuYW6k0";
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
                                    "visibility": "on"
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
                script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap&libraries=places`;
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

        })();
    </script>
    @endscript
</div>
