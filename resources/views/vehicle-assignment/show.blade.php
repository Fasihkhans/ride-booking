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

            <div class="h-auto p-4 bg-white">
                @livewire('vehicle-assignment.show',['id'=>$id])
            </div>
        </div>
    </x-app-layout>
</div>
