@component('mail::message')
Welcome to {{ config('app.name') }}
      
Name: {{ $mailData['name'] }}<br/>
Email: {{ $mailData['email'] }}
      
Thanks,<br/>
{{ config('app.name') }}
@endcomponent