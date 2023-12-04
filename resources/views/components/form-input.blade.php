@props([
    'errorMessage'
])
{{-- $errors->get('first_name') --}}
<div class="mb-3 col-md-4">
    <div class="form-group">
        <input {{ $attributes->merge(['class' => 'form-control']) }}>
        <x-input-error :messages="$errorMessage" class="mt-2" />
    </div>
</div>
