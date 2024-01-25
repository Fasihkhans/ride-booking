<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Forms\LogoutForm;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="max-h-full overflow-x-hidden bg-gray-100 sidenav navbar navbar-vertical align-items-center fixed-left navbar-expand-xs">
    <div class="" style="position: relative;">
        <div class=" align-items-center" style=" margin-bottom: 0px; margin-right: 0px;">
             <!-- Brand -->
            <div class="justify-center w-full p-3 sidenav-header d-flex align-items-center">
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9 dark:text-gray-200" />
                    </a>
                </div>
            </div>
            <!-- Divider -->
            <hr class="my-3">
            <div  class=" navbar-inner">
                <!-- Nav items -->
                <ul class="navbar-nav align-items-center">
                    <li class="m-2 nav-item">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    </li>
                    <li class="m-2 nav-item">
                        <x-nav-link :href="route('driver.index')" :active="request()->routeIs('driver.*')" wire:navigate>
                            {{ __('Manage Drivers') }}
                        </x-nav-link>
                    </li>
                    <li class="m-2 nav-item">
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" wire:navigate>
                            {{ __('Manage Users') }}
                        </x-nav-link>
                    </li>
                    <li class="m-2 nav-item">
                        <x-nav-link :href="route('vehicles.index')" :active="request()->routeIs('vehicles.*')" wire:navigate>
                            {{ __('Manage Vehicles') }}
                        </x-nav-link>
                    </li>
                    <li class="m-2 nav-item">
                        <x-nav-link :href="route('vehicle-types.index')" :active="request()->routeIs('vehicle-types.*')" wire:navigate>
                            {{ __('Manage Vehicle Types ') }}
                        </x-nav-link>
                    </li>
                    <li class="m-2 nav-item">
                        <x-nav-link :href="route('vehicle-assignment.index')" :active="request()->routeIs('vehicle-assignment.*')" wire:navigate>
                            {{ __('Manage Assignments') }}
                        </x-nav-link>
                    </li>
                    <li class="m-2 nav-item">
                        <x-nav-link :href="route('booking.index')" :active="request()->routeIs('booking.*')" wire:navigate>
                            {{ __('Manage Trips') }}
                        </x-nav-link>
                    </li>
                    <li class="m-2 border-t-2 nav-item">
                        <x-nav-link   :href="route('profile')"  :active="request()->routeIs('profile')">
                            {{ __('Setting') }}
                        </x-nav-link>
                    </li>
                    <li class="m-2 nav-item">
                        <x-nav-link   wire:click="logout"  :active="request()->routeIs('logout')">
                            {{ __('Log Out') }}
                        </x-nav-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
