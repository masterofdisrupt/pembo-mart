<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Mail\SendPDFMail;
use Mail;

class SendPDFController
{
    public function send_pdf()
    {
        return view('backend.admin.send_pdf.list');
    }

    public function send_pdf_sent(Request $request)
    {
        $request->validate([
            'doc_file' => 'required|file|mimes:pdf|max:2048',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);
        try {
            $file = $request->file('doc_file');
            $filePath = $file->store('documents');
            $fileUrl = asset('storage/app/' . $filePath);

            Mail::to($request->email)->send(new SendPDFMail($request, $filePath, $fileUrl));
        } catch (\Exception $e) {

        }

        return redirect()->route('send.pdf')->with('success', "Document Successfully Sent!");
    }

}
