(function () {
    function initMap() {
        // Apply the custom style to the map
        const map = new google.maps.Map(document.getElementById('maps'), {
            center: { lat: 54.532497, lng: -1.5605716 },
            zoom: 13,
            styles: style,
            gestureHandling: "none",
            fullscreenControl: false,
            mapTypeControl: false,
            streetViewControl: false,
        });

        // Add click event listener to the map
        google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(event.latLng, map);
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
                map: map
            });
        }
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



// import { Loader } from "@googlemaps/js-api-loader"
// (function () {
//     const loader = new Loader({
//      apiKey : "AIzaSyAK7e1i54SmdDqdhLDsK4PvkgveKuYW6k0",
//      style : [
//                     {
//                         "elementType": "geometry",
//                         "stylers": [
//                         {
//                             "color": "#212121"
//                         }
//                         ]
//                     },
//                     {
//                         "elementType": "labels.icon",
//                         "stylers": [
//                         {
//                             "visibility": "off"
//                         }
//                         ]
//                     },
//                     {
//                         "elementType": "labels.text.fill",
//                         "stylers": [
//                         {
//                             "color": "#757575"
//                         }
//                         ]
//                     },
//                     {
//                         "elementType": "labels.text.stroke",
//                         "stylers": [
//                         {
//                             "color": "#212121"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "administrative",
//                         "elementType": "geometry",
//                         "stylers": [
//                         {
//                             "color": "#757575"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "administrative.country",
//                         "elementType": "labels.text.fill",
//                         "stylers": [
//                         {
//                             "color": "#9e9e9e"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "administrative.land_parcel",
//                         "stylers": [
//                         {
//                             "visibility": "off"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "administrative.locality",
//                         "elementType": "labels.text.fill",
//                         "stylers": [
//                         {
//                             "color": "#bdbdbd"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "poi",
//                         "elementType": "labels.text.fill",
//                         "stylers": [
//                         {
//                             "color": "#757575"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "poi.park",
//                         "elementType": "geometry",
//                         "stylers": [
//                         {
//                             "color": "#181818"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "poi.park",
//                         "elementType": "labels.text.fill",
//                         "stylers": [
//                         {
//                             "color": "#616161"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "poi.park",
//                         "elementType": "labels.text.stroke",
//                         "stylers": [
//                         {
//                             "color": "#1b1b1b"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "road",
//                         "elementType": "geometry.fill",
//                         "stylers": [
//                         {
//                             "color": "#2c2c2c"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "road",
//                         "elementType": "labels.text.fill",
//                         "stylers": [
//                         {
//                             "color": "#8a8a8a"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "road.arterial",
//                         "elementType": "geometry",
//                         "stylers": [
//                         {
//                             "color": "#373737"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "road.highway",
//                         "elementType": "geometry",
//                         "stylers": [
//                         {
//                             "color": "#3c3c3c"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "road.highway.controlled_access",
//                         "elementType": "geometry",
//                         "stylers": [
//                         {
//                             "color": "#4e4e4e"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "road.local",
//                         "elementType": "labels.text.fill",
//                         "stylers": [
//                         {
//                             "color": "#616161"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "transit",
//                         "elementType": "labels.text.fill",
//                         "stylers": [
//                         {
//                             "color": "#757575"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "water",
//                         "elementType": "geometry",
//                         "stylers": [
//                         {
//                             "color": "#000000"
//                         }
//                         ]
//                     },
//                     {
//                         "featureType": "water",
//                         "elementType": "labels.text.fill",
//                         "stylers": [
//                         {
//                             "color": "#3d3d3d"
//                         }
//                         ]
//                     }
//                     ]
//                 });
//     loader.then(async () => {
//         const { Map } = await google.maps.importLibrary("maps");

//         map = new Map(document.getElementById("map"), {
//         center: { lat: 54.532497, lng: -1.5605716 },
//         zoom: 13,
//         styles: style,
//         gestureHandling: "none",
//         fullscreenControl: false,
//         mapTypeControl: false,
//         streetViewControl: false,
//         });

//         google.maps.event.addListener(map, 'click', function(event) {
//             placeMarker(event.latLng, map);
//         });

//         // Function to place a marker at a specific location
//         function placeMarker(location, map) {
//             // Remove existing marker (if any)
//             if (window.marker) {
//                 window.marker.setMap(null);
//             }
//             // Create a new marker
//             window.marker = new google.maps.marker.AdvancedMarkerElement({
//                 position: location,
//                 map: map
//             });
//         }
//     });
//     // function initMap() {
//     //     // Apply the custom style to the map
//     //     const map = new google.maps.Map(document.getElementById('maps'), {
//     //         center: { lat: 54.532497, lng: -1.5605716 },
//     //         zoom: 13,
//     //         styles: style,
//     //         gestureHandling: "none",
//     //         fullscreenControl: false,
//     //         mapTypeControl: false,
//     //         streetViewControl: false,
//     //     });

//     //     // Add click event listener to the map
//     //     google.maps.event.addListener(map, 'click', function(event) {
//     //         placeMarker(event.latLng, map);
//     //     });

//     //     // Function to place a marker at a specific location
//     //     function placeMarker(location, map) {
//     //         // Remove existing marker (if any)
//     //         if (window.marker) {
//     //             window.marker.setMap(null);
//     //         }
//     //         // Create a new marker
//     //         window.marker = new google.maps.marker.AdvancedMarkerElement({
//     //             position: location,
//     //             map: map
//     //         });
//     //     }
//     // }
//     // Check if the Google Maps API script has already been loaded
//     if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
//         // Load the Google Maps API script dynamically
//         const script = document.createElement('script');
//         script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap&libraries=places`;
//         script.defer = true;
//         script.async = true;

//         script.onload = () => {
//             // Once the script is loaded, call the initMap function
//             initMap();
//         };

//         script.onerror = () => {
//             console.error('Failed to load Google Maps API script.');
//         };

//         // Append the script to the document
//         document.head.appendChild(script);
//     } else {
//         // If the Google Maps API is already loaded, directly call the initMap function
//         initMap();
//     }

// })();
