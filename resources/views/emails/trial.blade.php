@component('mail::message')
Trial ended

Hi, <b>{{$name}}</b>
Your trial has ended today. To continue using our service, kindly click the button below to re-activate your membership.

@component('mail::button', ['url' => route('subscribe') ])
Re-activate membership
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
