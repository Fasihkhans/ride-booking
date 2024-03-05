@props([
    'title'
])
<div class="flex flex-col items-center justify-center p-2 border border-black shadow-md rounded-2xl">
    <dt class="mb-2 text-3xl font-extrabold">{{ $slot }}</dt>
    <dd class="text-black ">{{ $title }}</dd>
</div>
