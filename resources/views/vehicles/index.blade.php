<div>
    <x-app-layout>
        <x-page-header name="Vehicles">
            <a href="{{ route('vehicles.create') }}">
                <x-primary-button>
                    {{__('Add Vehicle')}}
                </x-primary-button>
            </a>
        </x-page-header>
    </x-app-layout>
</div>
