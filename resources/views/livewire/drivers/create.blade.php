<?php

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\DriverRepository;
use App\Helpers\Configuration;
use function Livewire\Volt\{state,usesFileUploads,rules,updated};

state([
    'first_name' => '',
    'last_name' => '',
    'phone_number' => '',
    'email' => '',
    'license_no' => '',
    'license_expiry' => '',
    'licenseImgUrl' => null
]);

usesFileUploads();

$save = function(){
    $validated = $this->validate([
        'first_name' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'last_name' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'licenseImgUrl' => ['required', 'image','mimes:jpeg,png,jpg','max:10000'],
        // 'licenseImgUrl' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
        'email' => ['required', 'string', 'email', 'unique:users', 'max:255'],
        'phone_number' => ['required', 'unique:users', 'regex:/^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/'],
        'license_no' => ['required', 'unique:drivers', 'regex:/^\+?[0-9\-\s]+$/'],
        'license_expiry' => ['required', 'date'],

    ]);
    // $this->licenseImgUrl->store('drivers','s3');
    // dd($this->licenseImgUrl);
    $validated += [
        'password' => Hash::make(Str::random(10)),
        'role_id' => Configuration::UserRole('driver'),
        'license_img_url' => $this->licenseImgUrl->store('drivers','public')
    ];

    $user = new UserRepository;
    $created = $user->create($validated);
    $validated += [
            'user_id' => $created->id
    ];
    $Driver = new DriverRepository;
    $Driver->create($validated);
    session()->flash('success','Driver has been created');
    $this->redirect(route('driver.index'));
}?>

<div>
    <div>
        @error('message')
                {{$message}}
        @enderror
    </div>

    <div class="col-8 h-[664px] bg-stone-50 rounded-[20px] border border-stone-300 p-4 ml-5">
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

            <div class="text-xl font-bold tracking-tight text-black">License Details</div>

            <div class="mt-4 form-row">
                <x-form-input :errorMessage="$errors->get('license_no')"  type="number" placeholder="License number" name="license_no" wire:model="license_no"/>

                <x-form-input :errorMessage="$errors->get('license_expiry')"  type="date" placeholder="license_expiry" name="license_expiry" wire:model="license_expiry"/>
            </div>
            <div class="mt-4 form-row">
                <div class="mb-3 col-md-6">
                    <div class="form-group">
                        <input type="file" class="form-control" placeholder="License number" wire:model="licenseImgUrl">
                        <x-input-error :messages="$errors->get('licenseImgUrl')" class="mt-2" />
                    </div>
                </div>
                {{-- <div class="mb-3 col-md-6">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFileLang" lang="en" wire:model="licenseImgUrl">
                            <label class="custom-file-label" for="customFileLang"> Registration Information</label>
                            <x-input-error :messages="$errors->get('licenseImgUrl')" class="mt-2" />
                          </div>
                    </div>
                </div> --}}
                @if ($licenseImgUrl)
                <img class="w-20"  src="{{ $licenseImgUrl->temporaryUrl() }}" alt="">
                @endif
            </div>
            {{-- <img src="https://dartscars-bucket-dev.s3.eu-west-1.amazonaws.com/image+15+(1).png" alt=""> --}}
            <x-primary-button>
                {{__('Continue')}}
            </x-primary-button>
      </form>
    </div>
</div>
{{--  --}}
