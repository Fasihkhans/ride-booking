@component('mail::message')
    {{ __('Hello there,') }}

    {{ __('Welcome aboard to Darts Cars, your gateway to seamless travels!') }}

    {{ __('Your verification code is: :code', ['code' => $verificationCode]) }}

    {{ __('Please use this code to finalize your registration or login securely. We are committed to keeping your information safe.') }}

    {{ __('Should you have received this email in error, feel free to disregard it. Your account remains under your control.') }}

    {{ __('Get ready to hit the road with confidence!') }}

@endcomponent
