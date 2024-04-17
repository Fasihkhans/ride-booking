<div>
    <div id="map" {{ $attributes->merge(['class' => 'w-full py-4 h-80 rounded-xl']) }}></div>
      <script>
        const apiKey = "{{ env('GOOGLE_MAPS_KEY') }}";
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
            key: apiKey,
            v: "weekly",
        });
            let map;
           async function initMap() {
                    const { Map } = await google.maps.importLibrary("maps"); // Destructure the 'maps' object
                    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

                    const directionsService = new google.maps.DirectionsService();
                    const directionsRenderer = new google.maps.DirectionsRenderer({
                        suppressMarkers: true,
                        polylineOptions: {
                            strokeColor: '#FFB800',
                        },
                    });


                     map = new Map(document.getElementById('map'), {
                        center: { lat: 54.532497, lng: -1.5605716 },
                        zoom: 13,
                        gestureHandling: "none",
                        mapId: "294912106c2419c5",
                    });

                    const origin = @json([$origin->latitude,$origin->longitude]).toString();
                    const destination = @json([$destination->latitude,$destination  ->longitude]).toString();
                    const originFlagImg = document.createElement("img");
                    const destinationFlagImg = document.createElement("img");
                    originFlagImg.src = @json(asset('assets/svg/origin-pointer.svg')).toString();
                    destinationFlagImg.src = @json(asset('assets/svg/destination-pointer.svg')).toString();
                    const originMarker = new google.maps.marker.AdvancedMarkerElement({
                        position: { lat: @json($origin->latitude), lng: @json($origin->longitude) },
                        map: map,
                        title: 'Origin',
                        content: originFlagImg
                    });

                    const destinationMarker = new google.maps.marker.AdvancedMarkerElement({
                        position: { lat: @json($destination->latitude), lng: @json($destination->longitude) },
                        map: map,
                        title: 'Destination',
                        content: destinationFlagImg
                    });
                    directionsService.route(
                        {
                            origin: origin,
                            destination: destination,
                            travelMode: 'DRIVING',
                        },
                        (response, status) => {
                            if (status === 'OK') {
                                directionsRenderer.setDirections(response);
                                directionsRenderer.setMap(map);
                            } else {
                                console.error('Directions request failed:', status);
                            }
                        }
                    );
                };
            console.log(@json([$destination->latitude,$origin->longitude]).toString());
            initMap();

    </script>
</div>
