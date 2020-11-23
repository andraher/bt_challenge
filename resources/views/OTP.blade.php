@component('mail::message')
# Hello there,

Your One Time Password is: {{ $otp }}. <br>
Have a nice day!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
