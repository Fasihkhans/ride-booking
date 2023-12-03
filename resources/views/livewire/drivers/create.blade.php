<?php

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\DriverRepository;
use App\Helpers\Configuration;
use function Livewire\Volt\{state,usesFileUploads,rules,updated};

state([
    'first_name',
    'last_name',
    'phone_number',
    'email',
    'license_no',
    'license_expiry',
    'license_img_url'
]);

usesFileUploads();

$save = function(){
    $validated = $this->validate([
        'first_name' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'last_name' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'email' => ['required', 'string', 'email', 'unique:users', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255'],
        'phone_number' => ['required', 'unique:users', 'regex:/^\+?[0-9\-\s]+$/'],
        'license_no' => ['required', 'unique:drivers', 'regex:/^\+?[0-9\-\s]+$/'],
        'license_expiry' => ['required', 'date'],
    ]);
    $validated += [
            'password' => Hash::make(Str::random(10)),
            'role_id' => Configuration::UserRole('driver'),
            'license_img_url' => $this->license_img_url->store('drivers')
        ];

    $user = new UserRepository;
    $created = $user->create($validated);
    $validated += [
            'user_id' => $created->id
    ];
    $Driver = new DriverRepository;
    $Driver->create($validated);
    session()->flash('success','Driver has been created');
}?>

<div>
    <div>
        @error('form')
                {{$message}}
        @enderror
    </div>

    <div class="col-8 h-[664px] bg-stone-50 rounded-[20px] border border-stone-300 p-4 ml-5">
        <x-auth-session-status class="mb-4" :status="session('success')" />
        <form wire:submit="save"  class="mt-4">
        <div class="text-xl font-bold tracking-tight text-black">Driver Details</div>
        <div class="mt-4 form-row">
          <div class="mb-3 col-md-4">
            <div class="form-group">
              <input type="text" class="form-control"  placeholder="First name" name="first_name" wire:model="first_name">
              <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>
          </div>
          <div class="mb-3 col-md-4">
            <div class="form-group">
              <input type="text" class="form-control"  placeholder="Last name" name="last_name" wire:model="last_name">
              <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
          </div>
          <div class="mb-3 col-md-4">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Contact number" name="phone_number" wire:model="phone_number">
              <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            </div>
          </div>
        </div>
        <div class="form-row">
            <div class="mb-3 col-md-4">
                <div class="form-group">
                  <input type="email" class="form-control"  placeholder="Email" name="name" wire:model.blur="email">
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
              </div>
        </div>

        <div class="text-xl font-bold tracking-tight text-black">License Details</div>

        <div class="mt-4 form-row">
          <div class="mb-3 col-md-6">
            <div class="form-group">
              <input type="number" class="form-control"  placeholder="License number" name="license_no" wire:model="license_no">
              <x-input-error :messages="$errors->get('license_no')" class="mt-2" />
            </div>
          </div>
          <div class="mb-3 col-md-3">
            <div class="form-group">
              <input type="date" class="form-control"  placeholder="Expiry date" name="license_expiry" wire:model="license_expiry">
              <x-input-error :messages="$errors->get('license_expiry')" class="mt-2" />
            </div>
          </div>
        </div>
        <div class="mt-4 form-row">
            <div class="mb-3 col-md-6">
              <div class="form-group">
                <input type="file" class="form-control"  placeholder="License number" wire:model="license_img_url">
                <x-input-error :messages="$errors->get('license_expiry')" class="mt-2" />
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
