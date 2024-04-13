@component('mail::message')


Congratualations, {{ $name }}<br><br>
You have been shortlisted for a job titled {{ $title }}. Kindly be ready for the interview.


Best Regards,<br>
{{ config('app.name') }}
@endcomponent
