<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();
        if(Auth::user()->role->name == 'admin'){
            // dd(Auth::user()->role->name);
            $this->redirect(
                session('url.intended', route('dashboard')),
                navigate: true
            );

        }
        if(Auth::user()->role->name == 'user'){
            // dd(Auth::user()->role->name);
            $this->redirect(
                session('url.intended', route('customer-home')),
                navigate: true
            );

        }
    }
}; ?>
<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">

        <h1 class="text-lg font-bold leading-loose text-zinc-950 ">Login</h1>
        <p class="my-2 font-normal text-black text-base/6 sm:text-sm/6 ">To continue please enter your credentials to logon to the service</p>
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block w-full mt-1 " type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block w-full mt-1"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex flex-wrap justify-between gap-2 mt-2">
            <label for="remember" class="inline-flex items-center self-start ">
                <input wire:model="form.remember" id="remember" type="checkbox" class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500 " name="remember">
                <span class="text-sm text-gray-600 ms-2 ">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="self-end text-sm text-indigo-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 " href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-center mt-4">

            <x-primary-button class="flex items-center justify-center w-full text-white capitalize rounded-[1.8rem] bg-zinc-800 hover:text-black">
                {{ __('Sign me in') }}
            </x-primary-button>
        </div>
    </form>
</div>
