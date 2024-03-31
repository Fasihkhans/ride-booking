<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Helpers\Configuration;
use Spatie\Permission\Models\Role;
use App\Repositories\VerificationCodeRepository;

new #[Layout('layouts.guest')] class extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $phone_number = '';
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'first_name' => ['required','regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
            'last_name' => ['required','regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
            'email' => ['required', 'string', 'email','lowercase', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255', 'unique:users'],
            'phone_number' => ['required','unique:users', 'regex:/^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role_id'] = 2;

        event(new Registered($user = User::create($validated)));

        // Auth::login($user);
        $user->assignRole(Role::findById($user->role_id, 'api'));
        $verificationCodeRepository = new VerificationCodeRepository();
        $verificationCodeRepository->generate($user->id, Configuration::VerificationPurpose('Account Verification'));

        $this->redirect(route('otp', ['email' => Crypt::encrypt($this->email)]), navigate: true);

    }
}; ?>

<div>
    <div class="text-3xl font-extrabold font-['Outfit']"> Lets create your account</div>

    <div class="text-xs my-2 font-extrabold font-['Outfit']">We'll walk you through a few simple steps to establish an account.</div>
    <form wire:submit="register">
        <!-- Name -->
        <div class="flex form-row">
            {{-- <div class="flex form-group"> --}}

            <div class="max-w-[50%] mr-1 form-group ">

                    <x-input-label for="firstName" :value="__('First Name')" />
                    <x-text-input wire:model="first_name" id="first_name" class="w-full mt-1" type="text" name="firstName" required autofocus autocomplete="first name" />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />

            </div>


            <div class="max-w-[50%] ml-1 form-group">

                    <x-input-label for="lastName" :value="__('last Name')" />
                    <x-text-input wire:model="last_name" id="last_name" class="w-full mt-1" type="text" name="lastName" required autofocus autocomplete="last name" />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />

            </div>

        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block w-full mt-1" type="email" name="email" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


         <!-- Phone Number -->
         <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input wire:model="phone_number" id="phone_number" class="block w-full mt-1" type="tel" pattern="\+[0-9]{2}\s[0-9]{2}\s[0-9]{4}\s[0-9]{4}" name="phone_number" placeholder="+44 12 1234 1234" required autocomplete="phone number"/>
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block w-full mt-1"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block w-full mt-1"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="flex items-center justify-center w-full text-white capitalize rounded-[1.8rem] bg-zinc-800 hover:text-black">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    <div class="inline-flex">

        <p class="mt-2 text-xs text-black-50">Already have an account?</p>
        <a class="m-1 text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 " href="{{ route('login') }}" wire:navigate>
            {{ __('login') }}
        </a>
    </div>
</div>
