<?php

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\DriverRepository;
use App\Helpers\Configuration;
use Illuminate\Validation\Rule;
use function Livewire\Volt\{state,usesFileUploads,rules,updated,mount};

state([
    'id',
    'driver',
    'first_name' => '',
    'last_name' => '',
    'phone_number' => '',
    'email' => '',
    'license_no' => '',
    'license_expiry' => '',
    'licenseImgUrl' => null,
    'status' => '',
    'license_img_url' => '',
]);
mount(function(){
    $this->driver = DriverRepository::findByIdWithUser(decrypt($this->id))->first();
    $this->id = $this->driver->user->id;
    $this->first_name = $this->driver->user->first_name;
    $this->last_name = $this->driver->user->last_name;
    $this->phone_number = $this->driver->user->phone_number;
    $this->email = $this->driver->user->email;
    $this->license_no = $this->driver->license_no;
    $this->license_expiry = $this->driver->license_expiry;
    $this->license_img_url = Storage::disk(env('CURRENT_IMG_DRIVER'))->url($this->driver->license_img_url)??Storage::disk('local')->url($this->driver->license_img_url);
    $this->status = $this->driver->user->status;
});

usesFileUploads();

$save = function(){
    $validated = $this->validate([
        'id' => ['required'],
        'first_name' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'last_name' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'email' => ['required', 'string', 'email', 'max:255','max:10000'],
        'licenseImgUrl' => ['nullable', 'image','mimes:jpeg,png,jpg'],
        'phone_number' => ['required', 'regex:/^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/'],
        'license_no' => ['required', 'unique:drivers,license_no,'.$this->driver->id, 'regex:/^[A-Za-z0-9]+$/'],
        'license_expiry' => ['required', 'date'],
        'status' => ['required',Rule::in('active','inActive')]

    ]);

    $validated += [
        'license_img_url' => $this->licenseImgUrl? $this->licenseImgUrl->store('drivers','s3'):$this->driver->license_img_url,
    ];

    UserRepository::update($validated);
    DriverRepository::updateDriver($this->driver->id,$validated);
    session()->flash('success','Driver has been created');
    $this->redirect(route('driver.index'));
}?>

<div>
    <div>
        @error('message')
                {{$message}}
        @enderror
    </div>

    <div class="col-8 h-auto bg-stone-50 shadow-lg rounded-[20px] border border-stone-900 p-4 ml-5">
        <x-auth-session-status class="mb-4" :status="session('success')" />
        <form wire:submit.prevent="save"  class="mt-4" enctype="multipart/form-data">
            <div class="text-xl font-bold tracking-tight text-black">Driver Details</div>
            <div class="mt-4 form-row">
                <x-form-input :errorMessage="$errors->get('first_name')"  type="text" placeholder="First name" name="first_name" wire:model="first_name"/>

                <x-form-input :errorMessage="$errors->get('last_name')"  type="text" placeholder="Last name" name="last_name" wire:model="last_name"/>

                <x-form-input :errorMessage="$errors->get('phone_number')"  type="text" placeholder="Contact number" name="phone_number" wire:model="phone_number"/>
            </div>
            <div class="form-row">
                <x-form-input :errorMessage="$errors->get('email')"  type="email" placeholder="Email" name="email" wire:model.blur="email"/>
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
            <div class="text-xl font-bold tracking-tight text-black">License Details</div>

            <div class="mt-4 form-row">
                <x-form-input :errorMessage="$errors->get('license_no')"  type="text" pattern="[a-zA-Z0-9]+" placeholder="License number" name="license_no" wire:model="license_no"/>

                <x-form-input :errorMessage="$errors->get('license_expiry')"  type="date" placeholder="license_expiry" name="license_expiry" wire:model="license_expiry" :value="$license_expiry ? \Carbon\Carbon::parse($license_expiry)->format('m-d-Y') : null"/>
            </div>

            <div class="mt-4 form-row">
                <div class="mb-3 col-md-6">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFileLang" lang="en" wire:model="licenseImgUrl" accept=".png, .jpg, .jpeg">
                            <label class="custom-file-label" for="customFileLang"> Registration Information</label>
                            <x-input-error :messages="$errors->get('licenseImgUrl')" class="mt-2" />
                          </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 form-row">
                <div class="mb-3 col-md-6">
                    <div class="form-group">

                        @if ($license_img_url)
                        {{-- <div class="border rounded-md border-neutral-950 h-50 w-50"> --}}
                        <div class="flex items-center justify-center max-w-xs align-middle bg-white border border-black rounded-lg shadow justify-items-center h-80 w-80">
                            <img class="w-full h-full rounded-lg object-fit" src="{{ $license_img_url }}" alt="">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <x-primary-button>
                {{__('Continue')}}
            </x-primary-button>
      </form>
    </div>
</div>
{{--  --}}
