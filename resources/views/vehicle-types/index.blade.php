<div>
    <x-app-layout>
        <x-page-header name="Vehicle Types">
            <a href="{{ route('vehicle-types.create') }}">
                <x-primary-button>
                    {{__('Add Vehicle Type')}}
                </x-primary-button>
            </a>
        </x-page-header>
        <div class="h-full p-4 bg-white">
            <livewire:vehicle-types.index>
        </div>
    </x-app-layout>
</div>
