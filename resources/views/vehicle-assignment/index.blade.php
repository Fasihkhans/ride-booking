<div>
    <x-app-layout>
        <x-page-header name="Assignments Summary">
            <a href="{{ route('download.vehicle-assignment.csv') }}">
                <x-primary-button>
                    {{__('Download as CSV')}}
                </x-primary-button>
            </a>
            <a href="{{ route('vehicle-assignment.create') }}">
                <x-primary-button>
                    {{__('New Assignment')}}
                </x-primary-button>
            </a>
        </x-page-header>
        <div class="h-full p-4 bg-white">
            <livewire:vehicle-assignment.index>
        </div>
    </x-app-layout>
</div>
