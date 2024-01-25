<div>
    <div id="map" class="w-full p-10 h-96 rounded-xl "></div>
    @script
    <script>
        (function () {
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
                script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=Function.prototype&libraries=places`;
                script.defer = true;
                script.async = true;

                script.onload = () => {
                    // Once the script is loaded, initialize the map
                    initMap();
                };

                script.onerror = () => {
                    console.error('Failed to load Google Maps API script.');
                };

                // Append the script to the document
                document.head.appendChild(script);
            } else {
                // If the Google Maps API is already loaded, initialize the map directly
                initMap();
            }

            // Function to initialize the map
            function initMap() {
                const { maps } = google; // Destructure the 'maps' object

                // Apply the custom style to the map
                const map = new maps.Map(document.getElementById('map'), {
                    center: { lat: 54.532497, lng: -1.5605716 },
                    zoom: 13,
                    styles: style, // Apply the custom style here
                    gestureHandling: "none",
                    // marker
                });
            }
        })();
    </script>
    @endscript
</div>
