<?php

use App\Models\User;
use App\Repositories\UserRepository;
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
    'status' => '',
]);
mount(function(){
    $userRepo = new UserRepository();
    $this->id = decrypt($this->id);
    $this->user = $userRepo->getById($this->id);
    $this->first_name = $this->user->first_name;
    $this->last_name = $this->user->last_name;
    $this->phone_number = $this->user->phone_number;
    $this->email = $this->user->email;
    $this->status = $this->user->status;
});

usesFileUploads();

$save = function(){
    $validated = $this->validate([
        'id' => ['required'],
        'first_name' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'last_name' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'phone_number' => ['required'], //'regex:/^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/'],
        'status' => ['required',Rule::in('active','inActive')]

    ]);


    UserRepository::update($validated);
    session()->flash('success','User has been updated');
    $this->redirect(route('users.index'));
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
            <div class="text-xl font-bold tracking-tight text-black">User Details</div>
            <div class="mt-4 form-row">
                <x-form-input :errorMessage="$errors->get('first_name')"  type="text" placeholder="First name" name="first_name" wire:model="first_name"/>

                <x-form-input :errorMessage="$errors->get('last_name')"  type="text" placeholder="Last name" name="last_name" wire:model="last_name"/>

                <x-form-input :errorMessage="$errors->get('phone_number')"  type="text" placeholder="Contact number" name="phone_number" wire:model="phone_number" disabled/>
            </div>
            <div class="form-row">
                <x-form-input :errorMessage="$errors->get('email')"  type="email" placeholder="Email" name="email" wire:model.blur="email" disabled/>
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
</div>
{{--  --}}
