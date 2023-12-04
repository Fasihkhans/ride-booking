<div>
    <x-app-layout>
        <div class="bg-white">

            <x-page-header name="Add a Vehicle">
                <a href="{{ route('vehicles.index') }}">
                    <x-primary-button>
                        {{__('Go Back')}}
                    </x-primary-button>
                </a>
            </x-page-header>
            <livewire:vehicles.create-form />
        </div>
    </x-app-layout>
</div>
