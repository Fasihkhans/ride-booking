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

      {{-- <div id="map" class="w-full h-screen p-6"></div> --}}

      {{-- <script>
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
          key: "YOUR_API_KEY",
          v: "weekly",
          // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
          // Add other bootstrap parameters as needed, using camel case.
        });
      </script> --}}
      {{-- <script async
      src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}_KEY&callback=initMap">
  </script> --}}
<section class="p-4">
    <h2> Current Trips</h2>
    <div id="map" class="w-full p-10 h-96 rounded-xl "></div>
</section>
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
