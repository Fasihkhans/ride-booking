<div>
    <input type="text" placeholder="{{ ucfirst($place_holder) }}..." class="w-full px-4 py-2 text-sm focus:outline-none focus:border-blue-500"
        wire:model.live="destination">
    {{-- @if(!empty($places)) --}}
    <ul class="absolute z-10 w-full mt-1 bg-white rounded shadow-md dropdown-menu" style="display: {{ count($places) > 0 ? 'block' : 'none' }}">
        @foreach($places as $place)
            <li><a href="#" wire:click.prevent="selectPlace({{ json_encode($place) }})" class="block px-4 py-2 hover:bg-blue-500 hover:text-white">{{ $place['description'] }}</a></li>
        @endforeach
    </ul>
    {{-- @endif --}}
</div>
