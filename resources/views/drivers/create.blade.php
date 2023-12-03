<div>
    <x-app-layout>
        <div class="bg-white">
            <x-page-header name="Add a New Driver">
                <a href="{{ route('profile') }}">
                    <x-primary-button>
                        {{__('Go Back')}}
                    </x-primary-button>
                </a>
            </x-page-header>

            <livewire:drivers.create/>
        </div>
    </x-app-layout>
</div>
