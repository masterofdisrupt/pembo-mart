<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Backend\V1\ComposeEmailModel;
use App\Mail\ComposeEmailMail;
use Mail;

class EmailController
{
    public function email_compose()
    {
        $data['getEmail'] = User::whereIn('role', ['agent', 'user'])->get();
        return view('backend.admin.email.compose', $data);
    }

    public function email_store(Request $request)
    {
        $save = new ComposeEmailModel;
        $save->user_id = $request->user_id;
        $save->cc_email = trim($request->cc_email);
        $save->subject = trim($request->subject);
        $save->description = trim($request->description);
        $save->save();

        //Email Start
        $getUserEmail = User::where('id', '=', $request->user_id)->first();

        Mail::to($getUserEmail->email)->cc($request->cc_email)->send(new ComposeEmailMail($save));
        //Email End

        return redirect('admin/email/compose')->with('success', "Email Successfully Sent!");
    }

    public function email_sent(Request $request)
    {
        // Count sent emails where 'is_sent' is 0
        $sentEmailsCount = ComposeEmailModel::where('is_sent', 0)->count();

        // Fetch all sent email records (optional, if you need to display them as well)
        $data['getRecord'] = ComposeEmailModel::where('is_sent', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(40);

        // Pass both the count and records to the view
        $data['sentEmailsCount'] = $sentEmailsCount;

        return view('backend.admin.email.send', $data);
    }



    public function email_sent_delete(Request $request)
    {
        // dd($request->all());
        $emailIds = explode(',', $request->input('email_ids'));

        if (empty($emailIds)) {
            return response()->json(['error' => 'No emails selected'], 400);
        }

        ComposeEmailModel::whereIn('id', $emailIds)->delete();

        return redirect(route('email.send'))->with('success', 'Email(s) deleted successfully.');

    }



}
