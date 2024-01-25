<div>
    <x-app-layout>
        <x-page-header name="Vehicles">
            <a href="{{ route('download.vehicles.csv') }}">
                <x-primary-button>
                    {{__('Download as CSV')}}
                </x-primary-button>
            </a>
            <a href="{{ route('vehicles.create') }}">
                <x-primary-button>
                    {{__('Add Vehicle')}}
                </x-primary-button>
            </a>
        </x-page-header>
        <div class="h-full p-4 bg-white">
            <livewire:vehicles.index>
        </div>
    </x-app-layout>
</div>
