<div>
    <x-app-layout>
        <div class="bg-white">
            <x-page-header name="Vehicle Assignment">
                <a href="{{ route('vehicle-assignment.index') }}">
                    <x-primary-button>
                        {{__('Go Back')}}
                    </x-primary-button>
                </a>
            </x-page-header>

            <livewire:vehicle-assignment.create/>
        </div>
    </x-app-layout>
</div>
