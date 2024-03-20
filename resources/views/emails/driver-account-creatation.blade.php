@component('mail::message')
        {{ __('Dear :name \,',['name'=> $name ]) }}

        {!! __('We are delighted to extend an invitation to join DartsCar\'s platform. As part of the onboarding process,')!!}
        {{__('we have generated a temporary password for you to access your account.') }}

        {{ __('Please find your temporary password below:')}}

        {{ __('Temporary Password: :code ', ['code' => $randomPassword]) }}

        {{ __('For security purposes, we recommend that you change your password upon your initial login.')}}
        {{ __('To access the platform, please follow the instructions below:') }}

        {{ __('Visit https://play.google.com/store/apps/details?id=com.dartscars')}}

        {{ __('Enter your email address :email and the temporary password provided above.',['email'=> $email]) }}
        {{ __('Follow the prompts to set up your account and personalize your password.') }}

        {{ __('If you have any questions or encounter any difficulties during the login process,')}}
        {{ __('please do not hesitate to reach out to our support team at Jsataxigroup@gmail.com') }}

        {{ __('We are thrilled to have you join our platform and look forward to working together.') }}
@endcomponent
