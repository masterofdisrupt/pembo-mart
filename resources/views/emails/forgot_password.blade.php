@component('mail::message')
# Hi {{ $user->name }},

We received a request to reset your password. No worries — it happens to the best of us!

Just click the button below to create a new password:

@component('mail::button', ['url' => url('reset_password/' . $user->remember_token)])
Reset Your Password
@endcomponent

If you didn’t request a password reset, you can safely ignore this email — your password will stay the same.

Need help or have questions? Feel free to reach out to our support team and we’ll be happy to assist you.

@php
    $getSetting = \App\Models\SystemSetting::getSingleRecord();
    $websiteName = $getSetting->website;
@endphp

Thanks,  
{{ $websiteName }}
@endcomponent
