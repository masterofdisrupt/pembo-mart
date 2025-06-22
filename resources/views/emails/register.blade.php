@component('mail::message')
Hi, {{ $user->name }}.

@php
    $getSetting = \App\Models\SystemSetting::getSingleRecord();
    $websiteName = $getSetting->website ?? 'Soeatable';
@endphp

Welcome to {{ $getSetting->$websiteName }}! We are excited to have you on board.

To complete your registration, please verify your email address by clicking the link below:

If you did not create an account, please ignore this email.

Do not panic. Kindly, click the link below...

@component('mail::button', ['url' => url('activate_email/' . base64_encode($user->id))])
    Verify Email
@endcomponent


If you have any questions or need assistance, feel free to reach out to our support team.

Thank you for joining us!

Best regards,  
The Team  
Note: This is an automated message, please do not reply.

Thank You
@endcomponent
