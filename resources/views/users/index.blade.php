<div>
    <x-app-layout>
        <x-page-header name="Users">
            <a href="{{ route('download.users.csv') }}">
                <x-primary-button>
                    {{__('Download as CSV')}}
                </x-primary-button>
            </a>
            {{-- <a href="{{ route('driver.create') }}">
                <x-primary-button>
                    {{__('Add Drvier')}}
                </x-primary-button>
            </a> --}}
        </x-page-header>
        <div class="h-full p-4 bg-white">
            <livewire:users.index>
        </div>
    </x-app-layout>
</div>
