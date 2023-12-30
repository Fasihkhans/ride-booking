<?php
use App\Repositories\VehiclesRepository;
use App\Repositories\VehicleTypesRepository;
use App\Repositories\VehicleUploadsRepository;
use App\Constants\Constants;
use function Livewire\Volt\{state,usesFileUploads,rules,updated,mount};

state([
    'id',
    'make' => '',
    'model' => '',
    'year' => '',
    'license_no_plate' => '',
    'color' => '',
    'max_capacity' => '',
    'uploadVehiclePhotos' => null,
    'uploadVehicleLicensePhotos' => null,
    'vehicleTypes'=> '',
    'vehicle_type_id' => '',
    'vehicle'=>'',
    'VehiclePhotos',
    'status'
]);
mount(function(){
    $this->vehicleTypes = VehicleTypesRepository::getAll();
    $this->vehicle = VehiclesRepository::getVehicle(decrypt($this->id));
    $this->id = $this->vehicle->id;
    $this->make = $this->vehicle->make;
    $this->model = $this->vehicle->model;
    $this->year = $this->vehicle->year;
    $this->license_no_plate = $this->vehicle->license_no_plate;
    $this->color = $this->vehicle->color;
    $this->max_capacity = $this->vehicle->max_capacity;
    $this->vehicle_type_id = $this->vehicle->vehicle_type_id;
    $this->VehiclePhotos = $this->vehicle->vehicleUploads;
    $this->status = $this->vehicle->status;
});

usesFileUploads();

$save = function(){

    $validated = $this->validate([
        'make' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'model' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'year' => ['required','digits:4','integer','min:1900','max:'.(date('Y')+1)],
        'license_no_plate' => [ 'required','regex:/^[A-Z0-9]+$/i','max:15',],
        'color' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'max_capacity' => ['required', 'integer', 'min:1', 'max:100'],
        'uploadVehiclePhotos.*' => ['nullable', 'image','mimes:jpeg,png,jpg','max:10000'],
        'uploadVehicleLicensePhotos.*' => ['nullable', 'image','mimes:jpeg,png,jpg','max:10000'],
        'vehicle_type_id' => ['required', 'integer']
    ]);
    $validated +=[
        'status' => $this->status
    ];
    $vehicle = VehiclesRepository::update($this->vehicle,$validated);
    if($this->uploadVehiclePhotos){
        foreach($this->uploadVehiclePhotos as $uploadVehiclePhoto) {
            $vehicleUpload['vehicle_id'] = $vehicle->id;
            $vehicleUpload['upload_url'] =  $uploadVehiclePhoto->store('vehicles');
            $vehicleUpload['upload_type'] = "VehiclePhotos";
            VehicleUploadsRepository::create($vehicleUpload);
            $vehicleUpload = null;
        }
    }
    if ($this->uploadVehicleLicensePhotos) {
        foreach($this->uploadVehicleLicensePhotos as $uploadVehicleLicensePhoto) {
            $vehicleUpload['vehicle_id'] = $vehicle->id;
            $vehicleUpload['upload_url'] =  $uploadVehicleLicensePhoto->store('vehicles');
            $vehicleUpload['upload_type'] = "VehicleLicensePhotos";
            VehicleUploadsRepository::create($vehicleUpload);
            $vehicleUpload = null;
        }
    }


    session()->flash('success','Vehicle has been added');
    $this->redirect(route('vehicles.index'));
}?>

<div>
    <div class="col-8 min-h-full bg-stone-50 rounded-[20px] border border-stone-300 p-4 ml-5">
        <x-auth-session-status class="mb-4" :status="session('success')" />
        <form wire:submit="save"  class="mt-4">
            <div class="text-xl font-bold tracking-tight text-black">Vehicle Details</div>
            <div class="mt-4 form-row">
                <x-form-input :errorMessage="$errors->get('make')"  type="text" placeholder="Make" name="male" wire:model="make"/>
                <x-form-input :errorMessage="$errors->get('model')"  type="text" placeholder="Model" name="model" wire:model="model"/>
                <x-form-input :errorMessage="$errors->get('year')"  type="text" placeholder="Year" name="year" wire:model="year"/>
            </div>
            <div class="mt-4 form-row">
                <x-form-input :errorMessage="$errors->get('license_no_plate')"  type="text" placeholder="License Plate Number" name="license_no_plate" wire:model="license_no_plate"/>
                <x-form-input :errorMessage="$errors->get('color')"  type="text" placeholder="Color" name="color" wire:model="color"/>
                <x-form-input :errorMessage="$errors->get('max_capacity')"  type="number" placeholder="Maximum Passenger Capacity" name="max_capacity" wire:model="max_capacity"/>
            </div>
            <div class="mt-4 text-xl font-bold tracking-tight text-black">Vehicle Type</div>
            <div class="mt-4 form-row">
                <div class="col-md-12">
                    @foreach ($vehicleTypes as $vehicleType)
                        <label class="vehicle-type-select">
                            <input type="radio" name="vehicle_id" wire:model="vehicle_type_id" value="{{ $vehicleType->id }}" />
                            <span class="checkmark"></span>
                                <div class="inline-flex items-center justify-center px-1 pt-4 pb-2 ml-5 w-14 h-14">
                                    <img  class="mx-3 radio-img" src="{{Storage::disk('public')->url($vehicleType->upload_url) }}"/>
                                </div>
                            <div class="text-center text-sm font-bold font-['Urbanist'] tracking-tight capitalize">{{ $vehicleType->name }}</div>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="mt-4 text-xl font-bold tracking-tight text-black">Vehicle Photos</div>
            <div class="mt-4 form-row">
                <div class="mb-3 col-md-6">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFileLang" lang="en" wire:model="uploadVehiclePhotos" multiple>
                            <label class="custom-file-label" for="customFileLang">Vehicle Photos</label>
                            <x-input-error :messages="$errors->get('uploadVehiclePhotos')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 form-row">
                @foreach ($VehiclePhotos as $VehiclePhoto)
                    @if ($VehiclePhoto->upload_type == 'VehiclePhotos')
                        <div class="mb-3 col-md-3">
                            <div class="form-group">
                                <div class="flex items-center justify-center w-full max-w-xs p-2 align-middle bg-white border border-black rounded-lg shadow justify-items-center h-36">
                                    <img class="flex" src="{{ Storage::disk('public')->url($VehiclePhoto->upload_url) }}" alt="">
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="mt-4 text-xl font-bold tracking-tight text-black">Vehicle License and Registration Information</div>
            <div class="mt-4 form-row">
                <div class="mb-3 col-md-6">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFileLang" lang="en" wire:model="uploadVehicleLicensePhotos" multiple>
                            <label class="custom-file-label" for="customFileLang"> Registration Information</label>
                            <x-input-error :messages="$errors->get('uploadVehicleLicensePhotos')" class="mt-2" />
                          </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 form-row">
                @foreach ($VehiclePhotos as $VehiclePhoto)
                    @if ($VehiclePhoto->upload_type == 'VehicleLicensePhotos')
                        <div class="mb-3 col-md-3">
                            <div class="form-group">
                                <div class="flex items-center justify-center w-full max-w-xs p-2 align-middle bg-white border border-black rounded-lg shadow justify-items-center h-36">
                                    <img class="flex max-h-36" src="{{ Storage::disk('public')->url($VehiclePhoto->upload_url) }}" alt="">
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="text-xl font-bold tracking-tight text-black">Status</div>

            <div class="mt-4 form-row">
                <div class="mb-3 col-md-6">
                    <div class="form-group">
                        <select name="status" wire:model="status">
                            @foreach(['active', 'inActive'] as $option)

                                <option value="{{ $option }}" @if($status == $option) selected @endif>{{ strtolower($option) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <x-primary-button>
                {{__('Continue')}}
            </x-primary-button>
      </form>
    </div>

    <style>
    .vehicle-type-select {
        align-content: center;
        margin-right: 10px;
        cursor: pointer;
        width: 152px;
        height: 90px;
        border-width: 1px;
        --tw-border-opacity: 1;
        border-color: rgb(254 243 199 / var(--tw-border-opacity));
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        border-radius: 10px;
        justify-content: center;
        color: #000;
    }

    .vehicle-type-select input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .vehicle-type-select:hover {
        background-color: #ccc;
    }
    img.radio-img {
        /* display: block;
        width: 4rem;
        color: #000; */
        filter: invert(25%);
    }

    .vehicle-type-select > .checkmark {
        display: inline-block;
        position: relative;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        border: 2px solid #27272a;
        background-color: #fff;
        margin: 5px;
        float: right;
        top: 0;
    }

    .vehicle-type-select input:checked ~ .checkmark {
        border: 2px solid #ffffff;
        background-color: #000000;

    }

    .vehicle-type-select input:checked ~ div > .radio-img {
        filter: invert(0%);
    }
    .vehicle-type-select:has(> input:checked) {
        background-color: #000 !important; /* Background color of the entire .vehicle-type-select when checked */
        transition: background-color 0.3s;
        color:#fff;
    }
    </style>
</div>
