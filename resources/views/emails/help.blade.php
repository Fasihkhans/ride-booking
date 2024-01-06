@component('mail::message')
    {{ __('This email from  your website\'s help page') }}

    {{ __('Name : :Name',['Name'=>$data['name']]) }}
    {{ __('Email : :Email',['Email'=>$data['email']]) }}
    {{ __('Message : :Message',['Message'=>$data['message']]) }}
@endcomponent
