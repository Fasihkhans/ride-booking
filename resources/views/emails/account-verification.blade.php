@component('mail::message')
    {{ __('The verification code for Darts Cars is :code ', ['code' => $verificationCode]) }}

    {{ __('If you did not expect to receive this email, you may discard this email.') }}
@endcomponent
