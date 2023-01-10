@component('mail::message')
# {{$mailData['subject']}}

hello,
{{$mailData['name']}}
<br>
<br>
{{$mailData['line']}}
<br>

# Request Detail

<b>Name</b> : {{ $mailData['username'] }}
<br>
<b>Email</b> : {{ $mailData['email'] }}
<br>
@component('mail::panel')
<b>Message</b> :  {{ $mailData['message'] }}
@endcomponent
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
