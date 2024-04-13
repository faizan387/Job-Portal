@component('mail::message')
# Congratulations

You are now a premium user.
<p>Your purchase details:</p>
<p>Plan: {{$plan}}</p>
<p>Your plan ends on: {{$billingEnd}}</p>

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
