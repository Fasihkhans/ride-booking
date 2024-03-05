<?php

// use App\Models\User;
use App\Constants\Constants;
use App\Repositories\UserRepository;
use App\Repositories\DriverRepository;
use App\Repositories\VehiclesRepository;
use App\Repositories\DriverVehiclesRepository;
use App\Helpers\Configuration;
use carbon\carbon;
use function Livewire\Volt\{state,usesFileUploads,rules,updated,mount};

state([
    'id',
    'assignment',
    'drivers'=>'',
    'vehicles' => '',
    'start_date' => '',
    'end_date' => '',
    'start_time' => '',
    'end_time' => '',
    'driver_id'=>'',
    'vehicle_id'=>'',
    'status' =>''
]);

mount(function(){
        $this->drivers = DriverRepository::getAllActiveDrivers();
        $this->vehicles = VehiclesRepository::getAllActiveVehicles();
        $this->assignment = DriverVehiclesRepository::findById(decrypt($this->id));
        $this->start_date = $this->assignment->start_date;
        $this->end_date = $this->assignment->end_date;
        $this->start_time = $this->assignment->start_time->format('H:i');
        $this->end_time = $this->assignment->end_time->format('H:i');
        $this->driver_id = $this->assignment->driver_id;
        $this->vehicle_id = $this->assignment->vehicle_id;
        $this->status = $this->assignment->status;
    });

usesFileUploads();

$save = function(){
    $validated = $this->validate([
        'start_date' => ['required', 'date'],
        'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        'start_time' => ['required', 'date_format:H:i'],
        'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        'driver_id' => ['required', 'numeric'],
        'vehicle_id' => ['required', 'numeric'],
    ],
    [
        'driver_id.required' => 'The driver field is required.',
        'driver_id.numeric' => 'The driver must be a number.',
        'vehicle_id.required' => 'The vehicle field is required.',
        'vehicle_id.numeric' => 'The vehicle must be a number.',
    ]);
    $validated['status'] = $this->status;
    $Driver = DriverVehiclesRepository::update($this->assignment, $validated);
    session()->flash('success','Vehicle has been assigned to driver');
    $this->redirect(route('vehicle-assignment.index'));
}?>

<div>
    <div>
        @error('message')
                {{$message}}
        @enderror
    </div>

    <div class="col-8 h-[664px] bg-stone-50 rounded-[20px] border border-stone-300 p-4 ml-5">
        <x-auth-session-status class="mb-4" :status="session('success')" />
        <form wire:submit="save"  class="mt-4">
            <div class="text-xl font-bold tracking-tight text-black">Vehicle information</div>
            <div class="mt-4 form-row">
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
            </div>
            <div class="text-xl font-bold tracking-tight text-black">Start Date and time</div>
            <div class="mt-4 form-row">
                <x-form-input :errorMessage="$errors->get('start_date')"  type="date" placeholder="Start Date" name="startDate" id="startDate" wire:model='start_date'/>
                <x-form-input :errorMessage="$errors->get('start_time')"  type="time" placeholder="Start Time" name="startTime" id="startTime" wire:model='start_time'/>
            </div>
            <div class="text-xl font-bold tracking-tight text-black">End Date and time</div>
            <div class="mt-4 form-row">
                <x-form-input :errorMessage="$errors->get('end_date')"  type="date" placeholder="End Date" name="endDate" id="endDate" wire:model='end_date'/>
                <x-form-input :errorMessage="$errors->get('end_time')"  type="time" placeholder="End Time" name="endTime" id="endTime" wire:model='end_time'/>
            </div>

            <div class="text-xl font-bold tracking-tight text-black">Status</div>

            <div class="mt-4 form-row">
                <div class="mb-3 col-md-6">
                    <div class="form-group">
                        <select name="status" class="border rounded border-stone-300" wire:model="status">
                            @foreach(['active', 'inActive'] as $option)
                                <option value="{{ $option }}" @if($status == $option) selected @endif>{{ strtolower($option) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <x-primary-button>
                {{__('save')}}
            </x-primary-button>
      </form>
    </div>
</div>
{{--  --}}
