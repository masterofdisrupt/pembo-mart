<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\Backend\V1\SMTPModel;


class SMTPController
{
   public function smtp_list(Request $request)
{
    $smtpRecord = SMTPModel::getSingleFirst();

    if (!$smtpRecord) {
        return redirect()->back()->with('error', 'SMTP settings not found.');
    }

    return view('backend.admin.smtp.update', ['getRecord' => $smtpRecord]);
}


    public function smtp_update(Request $request)
{
    // Validate the request data
    $request->validate([
        'app_name'         => 'required|string|max:255',
        'mail_mailer'      => 'required|string|max:50',
        'mail_host'        => 'required|string|max:255',
        'mail_port'        => 'required|integer|min:1|max:65535',
        'mail_username'    => 'required|string|max:255',
        'mail_password'    => 'nullable|string|min:8', // Allow nullable in case the user doesn't want to update it
        'mail_encryption'  => 'required|string|in:tls,ssl,null',
        'mail_from_address'=> 'required|email|max:255',
    ]);

    // Get the first SMTP record
    $save = SMTPModel::getSingleFirst();

    if (!$save) {
        return redirect()->back()->with('error', "SMTP settings not found.");
    }

    // Update fields
    $save->app_name = trim($request->app_name);
    $save->mail_mailer = trim($request->mail_mailer);
    $save->mail_host = trim($request->mail_host);
    $save->mail_port = trim($request->mail_port);
    $save->mail_username = trim($request->mail_username);

    // Only update the password if it's provided
    if ($request->filled('mail_password')) {
        $save->mail_password = trim($request->mail_password);
    }

    $save->mail_encryption = trim($request->mail_encryption);
    $save->mail_from_address = trim($request->mail_from_address);

    // Save the updated settings
    $save->save();

    return redirect()->route('smtp')->with('success', "SMTP Successfully Updated!");
}

}
