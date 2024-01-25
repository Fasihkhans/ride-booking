<?php
use App\Repositories\VehicleTypesRepository;
use function Livewire\Volt\{state,usesFileUploads,rules,updated,mount};

state([
    'id',
    'name' => '',
    'base_fare' => '',
    'per_minute_rate' => '',
    'per_mile_rate' => '',
    'min_mintues' => '',
    'min_miles' => '',
    'holiday_rate' => '',
    'peak_hour_rate' => '',
    'upload' => null,
    'night_base_fare' => '',
    'night_per_minute_rate' => '',
    'night_per_mile_rate' => '',
    'upload_url' =>'',
    'vehicleType'
]);

usesFileUploads();

mount(function(){
    $this->vehicleType = VehicleTypesRepository::findById(decrypt($this->id));
    $this->id = $this->vehicleType->id;
    $this->name = $this->vehicleType->name;
    $this->base_fare = $this->vehicleType->base_fare;
    $this->per_minute_rate = $this->vehicleType->per_minute_rate;
    $this->per_mile_rate = $this->vehicleType->per_mile_rate;
    $this->min_mintues = $this->vehicleType->min_mintues;
    $this->min_miles = $this->vehicleType->min_miles;
    $this->holiday_rate = $this->vehicleType->holiday_rate;
    $this->peak_hour_rate = $this->vehicleType->peak_hour_rate;
    $this->night_base_fare = $this->vehicleType->night_base_fare;
    $this->night_per_minute_rate = $this->vehicleType->night_per_minute_rate;
    $this->night_per_mile_rate = $this->vehicleType->night_per_mile_rate;
    $this->upload_url = Storage::disk(env('CURRENT_IMG_DRIVER'))->url($this->vehicleType->upload_url)??Storage::disk('local')->url($this->vehicleType->upload_url);
});

$save = function(){
    $validated = $this->validate([
        'name' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'base_fare' => ['required', 'decimal:2'],
        'per_minute_rate' => ['required', 'decimal:2'],
        'per_mile_rate' => ['required', 'decimal:2'],
        'min_mintues' => ['required', 'decimal:2'],
        'min_miles' => ['required', 'decimal:2'],
        'holiday_rate' => ['required', 'decimal:2'],
        'peak_hour_rate' => ['required', 'decimal:2'],
        'upload' => ['nullable', 'file'],
        'night_base_fare' => ['required', 'decimal:2'],
        'night_per_minute_rate' => ['required', 'decimal:2'],
        'night_per_mile_rate' => ['required', 'decimal:2'],

    ]);
    $validated += [
            'upload_url' => $this->upload? $this->upload->store('vehicle-types','s3'): $this->upload_url
        ];

    if(VehicleTypesRepository::update($this->vehicleType,$validated))
    {
        session()->flash('success','Type has been updated');
        $this->redirect(route('vehicle-types.index'));
    }

}?>

<div>
    <div class="col-8 min-h-full bg-stone-50 rounded-[20px] border border-stone-300 p-4 ml-5">
        <x-auth-session-status class="mb-4" :status="session('success')" />
        <form wire:submit="save"  class="mt-4">
            <div class="text-xl font-bold tracking-tight text-black">Type Details</div>
            <div class="mt-4 form-row">
                <div class="relative">
                    {{-- <x-input-label for="name" class="absolute z-10 px-1 ml-1 text-sm duration-100 ease-linear -translate-y-3 bg-white left-1 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:ml-1 peer-focus:-translate-y-3 peer-focus:px-1 peer-focus:text-sm" :value="__('name')" /> --}}
                </div>
                <x-form-input class="w-full border-b peer placeholder:text-transparent"  :errorMessage="$errors->get('name')"  type="text" placeholder="Name" name="name" wire:model="name"/>
                    <div class="mb-3 col-md-6">
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFileLang" lang="en" wire:model="upload">
                                <label class="custom-file-label" for="customFileLang">Vehicle Type Icon</label>
                                <x-input-error :messages="$errors->get('upload')" class="mt-2" />
                            </div>
                        </div>
                    </div>
            </div>
            <div class="mt-4 form-row">
                <div class="mb-3 col-md-3">
                    <div class="form-group">
                        <div class="flex items-center justify-center w-full max-w-xs p-2 align-middle bg-gray-200 border border-black rounded-lg shadow justify-items-center h-36">
                            <img src="{{ $upload?$upload->temporaryUrl():$this->upload_url }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-xl font-bold tracking-tight text-black">Set Pricing</div>
            <div class="py-2 text-lg font-normal tracking-tight text-black">Day Rates</div>
            <div class="mt-2 form-row">
                <x-form-input :errorMessage="$errors->get('base_fare')"  type="text" placeholder="Base Fare" name="fare" wire:model="base_fare"/>
                <x-form-input :errorMessage="$errors->get('per_minute_rate')"  type="text" placeholder="per-minute Rate" name="fare" wire:model="per_minute_rate"/>
                <x-form-input :errorMessage="$errors->get('per_mile_rate')"  type="text" placeholder="per-mile Rate" name="fare" wire:model="per_mile_rate"/>
            </div>
            <div class="py-2 text-lg font-normal tracking-tight text-black">Night Rates</div>
            <div class="mt-2 form-row">
                <x-form-input :errorMessage="$errors->get('night_base_fare')"  type="text" placeholder="Base Fare" name="fare" wire:model="night_base_fare"/>
                <x-form-input :errorMessage="$errors->get('night_per_minute_rate')"  type="text" placeholder="per-minute Rate" name="fare" wire:model="night_per_minute_rate"/>
                <x-form-input :errorMessage="$errors->get('night_per_mile_rate')"  type="text" placeholder="per-mile Rate" name="fare" wire:model="night_per_mile_rate"/>
            </div>
            <div class="text-lg font-bold tracking-tight text-black">Additional charges</div>

            <div class="mt-2 form-row">
                <x-form-input :errorMessage="$errors->get('peak_hour_rate')"  type="text" placeholder="Peak Hour Rates" name="fare" wire:model="peak_hour_rate"/>
                <x-form-input :errorMessage="$errors->get('holiday_rate')"  type="text" placeholder="Holidays Rates" name="fare" wire:model="holiday_rate"/>
            {{-- </div>
            <div class="mt-2 form-row"> --}}
                <x-form-input :errorMessage="$errors->get('min_mintues')"  type="text" placeholder="Minimum Mintues" name="fare" wire:model="min_mintues"/>
                <x-form-input :errorMessage="$errors->get('min_miles')"  type="text" placeholder="Minimum Miles" name="fare" wire:model="min_miles"/>
            </div>
            <x-primary-button>
                {{__('Continue')}}
            </x-primary-button>
      </form>
    </div>
</div>
