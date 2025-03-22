@component('mail::message')
    Hello!!!

    <p><b>Email ID : </b></p>
    <p><b>Subject : </b></p>
    <p><b>Message : </b></p>

    Thank you, <br>
    {{ config('app.name') }}
@endcomponent
