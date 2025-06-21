@component('mail::message')
    Hi, {{ $save->username }}. Please set new account password

    <p>Do not panic. Kindly, click the link below...</p>

    @component('mail::button', ['url' => url('set_new_password/' . $save->remember_token)])
        Set Your Password
    @endcomponent

    Thank You
    @php
        $getSetting = \App\Models\SystemSetting::getSingleRecord();
        $websiteName = $getSetting->website ?? 'Soeatable';
    @endphp
    <br>
    {{ $getSetting->$websiteName }}
    
@endcomponent
