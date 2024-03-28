<?php

namespace App\Livewire\Customers\Components;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Attributes\On;

class PlacesAutocomplete extends Component
{
    public $places = [];
    public $type;
    public $destination;
    public $place_id;
    public $place_holder;

    public function mount($type,$place_holder)
    {
        $this->type = $type;
        $this->place_holder= $place_holder;
        $this->destination;
    }


    public function updatedDestination()
    {

        $response = Http::get('https://maps.googleapis.com/maps/api/place/autocomplete/json', [
            'input' => $this->destination,
            'key' => env('GOOGLE_MAPS_KEY'),
            'components'=>'country:gb' // search results with in UK
        ]);

        $data = $response->json();
        $this->places = $data['predictions'];

    }

    public function selectPlace($selectedPlace)
    {

        $this->destination = $selectedPlace['description'];
        $this->place_id = $selectedPlace['place_id'];
        $this->places = [];
        $this->dispatch('selected-place',['placeId'=>$this->place_id]);
        $this->placeDetails($this->place_id);

    }


    public function placeDetails($placeId)
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
            'fields'=>'geometry',
            'place_id'=>$placeId,
            'key' => env('GOOGLE_MAPS_KEY'),
        ]);
        $data = $response->json();

        // dd($data);
        $geometry = $data['result']['geometry'];
        $this->dispatch('marker-location',$geometry);
        $this->createStop($this->destination,$geometry['location']['lat'],$geometry['location']['lng']);

    }

    #[On('marker-latlng')]
    public function markerLatlng($latlng)
    {
        // dd($latlng);
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng'=>$latlng['lat'].','.$latlng['lng'],
            'key' => env('GOOGLE_MAPS_KEY'),
        ]);
        $data = $response->json();
        // $this->placeDetails($data['plus_code']['global_code']);
        // dd($data);
        $this->destination=$data['plus_code']['compound_code'];
        $this->createStop($this->destination,$latlng['lat'],$latlng['lng']);

    }

    public function createStop($stop,$lat,$lng)
    {
        // dd($this->type);
        if($this->type == 'dropOff'){
            $sequenceNo = 2;
        }
        if($this->type == 'pickUp'){
            $sequenceNo = 1;
        }
        $data = [
            'stop' => $stop,
            'latitude' => $lat,
            'longitude' => $lng,
            'sequenceNo' => $sequenceNo,
            'type'=>$this->type,
        ];
        Session::put($this->type, $data);

    }

    public function render()
    {
        return view('livewire.customers.components.places-autocomplete');
    }
}
