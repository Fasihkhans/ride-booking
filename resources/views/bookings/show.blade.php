<div>
    <x-app-layout>
        <x-page-header name="Edit Driver">
            <a href="{{ route('driver.index') }}">
                <x-primary-button>
                    {{__('Go Back')}}
                </x-primary-button>
            </a>
        </x-page-header>
        <div class="h-auto p-4 bg-white">
            @livewire('booking.show',['id'=>$id])
        </div>
    </x-app-layout>
</div>
