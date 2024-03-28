@props(['url' => null])

@if ($url)
    <a href="{{ $url }}" ><button class="w-10 h-10 mb-5 text-white bg-black rounded-full btn btn-primary"><i class="fa-solid fa-arrow-left"></i></button></a>
@else
    <button onclick="window.history.back()" class="w-10 h-10 mb-5 text-white bg-black rounded-full btn btn-primary"><i class="fa-solid fa-arrow-left"></i></button>
@endif
