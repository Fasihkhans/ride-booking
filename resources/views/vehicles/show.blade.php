<div>
    <x-app-layout>
            <x-page-header name="Edit Vehicle">
                <a href="{{ route('vehicles.index') }}">
                    <x-primary-button>
                        {{__('Go Back')}}
                    </x-primary-button>
                </a>
            </x-page-header>
        <div class="h-auto p-4 bg-white">
            @livewire('vehicles.show',['id'=>$id])
        </div>
    </x-app-layout>
</div>
