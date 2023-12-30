<?php
use App\Repositories\VehicleTypesRepository;
use function Livewire\Volt\{state,usesFileUploads,rules,updated};

state([
    'name' => '',
    'base_fare' => '',
    'per_mintue_rate' => '',
    'per_mile_rate' => '',
    'min_mintues' => '',
    'min_miles' => '',
    'holiday_rate' => '',
    'peak_hour_rate' => '',
    'upload' => null,
    'night_base_fare' => '',
    'night_per_mintue_rate' => '',
    'night_per_mile_rate' => '',
]);

usesFileUploads();

$save = function(){
    $validated = $this->validate([
        'name' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'base_fare' => ['required', 'decimal:2'],
        'per_mintue_rate' => ['required', 'decimal:2'],
        'per_mile_rate' => ['required', 'decimal:2'],
        'min_mintues' => ['required', 'decimal:2'],
        'min_miles' => ['required', 'decimal:2'],
        'holiday_rate' => ['required', 'decimal:2'],
        'peak_hour_rate' => ['required', 'decimal:2'],
        'upload' => ['required', 'file'],
        'night_base_fare' => ['required', 'decimal:2'],
        'night_per_mintue_rate' => ['required', 'decimal:2'],
        'night_per_mile_rate' => ['required', 'decimal:2'],

    ]);
    $validated += [
            'upload_url' => $this->upload->store('drivers')
        ];

    VehicleTypesRepository::create($validated);

    session()->flash('success','Type has been created');
    $this->redirect(url()->previous());
}?>

<div>
    <div class="col-8 min-h-full bg-stone-50 rounded-[20px] border border-stone-300 p-4 ml-5">
        <x-auth-session-status class="mb-4" :status="session('success')" />
        <form wire:submit="save"  class="mt-4">
            <div class="text-xl font-bold tracking-tight text-black">Type Details</div>
            <div class="mt-4 form-row">
                <x-form-input :errorMessage="$errors->get('name')"  type="text" placeholder="Name" name="name" wire:model="name"/>
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
            <div class="text-xl font-bold tracking-tight text-black">Set Pricing</div>
            <div class="py-2 text-lg font-normal tracking-tight text-black">Day Rates</div>
            <div class="mt-2 form-row">
                <x-form-input :errorMessage="$errors->get('base_fare')"  type="text" placeholder="Base Fare" name="fare" wire:model="base_fare"/>
                <x-form-input :errorMessage="$errors->get('per_mintue_rate')"  type="text" placeholder="per-minute Rate" name="fare" wire:model="per_mintue_rate"/>
                <x-form-input :errorMessage="$errors->get('per_mile_rate')"  type="text" placeholder="per-mile Rate" name="fare" wire:model="per_mile_rate"/>
            </div>
            <div class="py-2 text-lg font-normal tracking-tight text-black">Night Rates</div>
            <div class="mt-2 form-row">
                <x-form-input :errorMessage="$errors->get('night_base_fare')"  type="text" placeholder="Base Fare" name="fare" wire:model="night_base_fare"/>
                <x-form-input :errorMessage="$errors->get('night_per_mintue_rate')"  type="text" placeholder="per-minute Rate" name="fare" wire:model="night_per_mintue_rate"/>
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
