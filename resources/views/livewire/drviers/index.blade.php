<?php

use function Livewire\Volt\{state};

//

?>

<x-app-layout>
    <a href="{{ route('driver.create') }}">
        <x-primary-button>
            {{__('Add drvier')}}
        </x-primary-button>
    </a>
</x-app-layout>
