<div>
    <x-app-layout>
        <x-page-header name="Drivers">
            <a href="{{ route('driver.create') }}">
                <x-primary-button>
                    {{__('Add Drvier')}}
                </x-primary-button>
            </a>
        </x-page-header>
        <div class="h-full p-4 bg-white">
            <livewire:drivers.index>
        </div>
    </x-app-layout>
</div>
