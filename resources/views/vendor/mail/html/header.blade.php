@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
{{-- {{ $slot }} --}}
<img src="https://dartscars.com/assets/png/dartscars-logo.svg" class="logo" alt="DartsCars Logo">

@endif
</a>
</td>
</tr>
