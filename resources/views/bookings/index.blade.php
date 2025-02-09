<div>
    <x-app-layout>
        <x-page-header name="Manage Trips">
            <a href="{{ route('download.booking.csv') }}">
                <x-primary-button>
                    {{__('Download as CSV')}}
                </x-primary-button>
            </a>
            {{-- <a href="{{ route('booking.create') }}">
                <x-primary-button>
                    {{__('Add booking')}}
                </x-primary-button>
            </a> --}}
        </x-page-header>
        <div class="p-4 bg-white ">
            <livewire:booking.index>
        </div>
    </x-app-layout>
</div>
