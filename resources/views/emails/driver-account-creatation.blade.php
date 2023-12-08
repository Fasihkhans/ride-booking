@component('mail::message')
    {{ __('The system generated password for Darts Cars is :code ', ['code' => $randomPassword]) }}

    {{ __('If you did not expect to receive this email, you may discard this email.') }}
@endcomponent
