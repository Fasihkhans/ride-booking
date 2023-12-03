<?php

// use function Livewire\Volt\{state};



?>

<div class="w-[848px] h-[664px] bg-stone-50 rounded-[20px] border border-stone-300 p-4 ml-5">
    <form wire:submit="save"  class="mt-4">
        @csrf
        <div class="text-black text-xl font-bold  tracking-tight">Driver Details</div>
        <div class="form-row mt-4">
          <div class="col-md-4 mb-3">
            <div class="form-group">
              <input type="text" class="form-control" id="validationServer01" placeholder="First name" wire:model="firstName" required="">
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="form-group">
              <input type="text" class="form-control" id="validationServer02" placeholder="Last name" wire:model="lastName" required="">
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="form-group">
              <input type="text" class="form-control" id="validationServerUsername01" placeholder="Contact number" wire:model="contactNumber" aria-describedby="inputGroupPrepend3" required="">
            </div>
          </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <div class="form-group">
                  <input type="email" class="form-control" id="validationServerUsername02" placeholder="Email" wire:model="email" aria-describedby="inputGroupPrepend3" required="">
                </div>
              </div>
        </div>

        <div class="text-black text-xl font-bold  tracking-tight">License Details</div>

        <div class="form-row mt-4">
          <div class="col-md-6 mb-3">
            <div class="form-group">
              <input type="text" class="form-control" id="validationServer03" placeholder="License number" wire:model="licenseNumber" required="">
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="form-group">
              <input type="date" class="form-control" id="validationServer05" placeholder="Expiry date" wire:model="expiryDate" required="">
            </div>
          </div>
        </div>
        <div class="form-row mt-4">
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <input type="file" class="form-control" id="validationServer03" placeholder="License number" wire:model="licenseImage">
              </div>
            </div>
          </div>
        <x-primary-button>
            {{__('Continue')}}
        </x-primary-button>
      </form>
</div>
