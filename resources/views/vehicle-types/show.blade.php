<div>
    <x-app-layout>
            <x-page-header name="Edit Vehicle Type">
                <a href="{{ route('vehicle-types.index') }}">
                    <x-primary-button>
                        {{__('Go Back')}}
                    </x-primary-button>
                </a>
            </x-page-header>
        <div class="h-auto p-4 bg-white">
            @livewire('vehicle-types.show',['id'=>$id])
        </div>
    </x-app-layout>
</div>
