<br>

Subject : - <b>{{ $save->subject }}</b>

<br>

Descriptions: - <b>{{ $save->description }}</b>

<br>

Thank You!

<br>
@php
    $getSetting = \App\Models\SystemSetting::getSingleRecord();
    $websiteName = $getSetting->website;
@endphp

<br>
{{ $websiteName }}
