<div>
    <x-app-layout>
        <x-page-header name="Edit Driver">
            <a href="{{ route('driver.index') }}">
                <x-primary-button>
                    {{__('Go Back')}}
                </x-primary-button>
            </a>
        </x-page-header>
        <div class="h-full p-4 bg-white">
            @livewire('drivers.show',['id'=>$id])
        </div>
    </x-app-layout>
</div>
