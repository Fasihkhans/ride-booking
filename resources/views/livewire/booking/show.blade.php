<?php
use App\Repositories\DriverRepository;
use App\Repositories\VehiclesRepository;
use App\Repositories\BookingRepository;
use function Livewire\Volt\{state,mount};

state([
    'id',
    'driver_id',
    'drivers'=>'',
    'vehicles' => '',
    'driver_id'=>'',
    'vehicle_id'=>'',
    'phone_number'=>'',
    'pick_up'=> '',
    'drop_off'=> '',
    'origin'=>'',
    'destination'=>'',
    'booking',
]);
mount(function(){
    $this->drivers = DriverRepository::getAllActiveDrivers();
    $this->vehicles = VehiclesRepository::getAllActiveVehicles();
    $this->booking = BookingRepository::findBooking(decrypt($this->id));
    $this->driver_id = $this->booking->driver_id;
    $this->vehicle_id = $this->booking->vehicle_id;
    $this->phone_number = $this->booking->driver?->user?->phone_number;
    $this->origin = $this->booking->bookingStops->first();
    $this->destination = $this->booking->bookingStops->last();
    $this->pick_up = $this->origin->stop;
    $this->drop_off = $this->destination->stop;
});
?>

<div>
    <section class="py-4">
        <div class="flex gap-1 ">
            <div class="col-4">
                <x-gmap class="h-svh" :origin='$origin' :destination='$destination'></x-gmap>
            </div>
            <div class="col-7 h-auto bg-stone-50 shadow-lg rounded-[20px] border border-stone-900 p-4 ml-5">
                <form wire:submit.prevent="save"  class="mt-4" enctype="multipart/form-data">
                    <div class="text-lg font-bold tracking-tight text-black">Vehicle and Driver <span class="{{ ($booking->status=='completed' || $booking->status=='active')?'bg-green-100 text-emerald-900':'bg-rose-100 text-red-800' }} p-1 rounded-md text-xs">
                        {{ ucfirst($booking->status) }}
                        </span></div>
                    <div class="mt-4 form-row">
                        <div class="mb-3 col-md-6">
                            <div class="form-group">
                                <select class="form-control" wire:model='driver_id' >
                                    <option>Select Driver</option>
                                    @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->user->first_name." ".$driver->user->last_name }}</option>
                                    @endforeach
                                  </select>
                                  <x-input-error :messages="$errors->get('driver_id')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <div class="form-group">
                                <select class="form-control"  wire:model='vehicle_id'>
                                    <option>Select Vehicle</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">
                                            {{ $vehicle->license_no_plate." ".$vehicle->make." ".$vehicle->year }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('vehicle_id')" class="mt-2" />
                            </div>
                        </div>

                    </div>
                    <div class="mt-2 form-row">
                        <x-form-input :errorMessage="$errors->get('phone_number')"  type="text" placeholder="Contact number" name="phone_number" wire:model="phone_number"/>
                    </div>
                    <div class="text-lg font-bold tracking-tight text-black">Trip</div>
                    <div class="mt-4 form-row">
                        <x-form-input :errorMessage="$errors->get('pick_up')"  type="text" placeholder="Pickup" name="pick_up" wire:model="pick_up"/>

                        <x-form-input :errorMessage="$errors->get('drop_off')"  type="text" placeholder="Drop off" name="drop_off" wire:model="drop_off"/>
                    </div>
                    <div class="text-lg font-bold tracking-tight text-black">Amount</div>
                    <div class="mt-4 form-row">
                        <x-form-input :errorMessage="$errors->get('pick_up')"  type="text" placeholder="Pickup" name="pick_up" wire:model="pick_up"/>

                        <x-form-input :errorMessage="$errors->get('drop_off')"  type="text" placeholder="Drop off" name="drop_off" wire:model="drop_off"/>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
