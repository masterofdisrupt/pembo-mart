@component('mail::message')
    Hello {{ $user->name }},

    We understand it happens.

    @component('mail::button', ['url' => url('reset/' . $user->remember_token)])
        Reset Your Password
    @endcomponent

    In case you have any issues recovering your password, please contact us.

    Thanks,
    {{ config('app.name') }}
@endcomponent
