<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\SystemSetting;
use App\Models\ContactUs;
use App\Mail\ContactUsMail;
use Session;
use Auth;
use Mail;

class HomeController
{
    public function index() {

        $metaData = [
            'meta_title' => 'Pembo-Mart',
            'meta_description' => '',
            'meta_keywords' => ''
        ];
        
        return view('home', [
            'meta_title' => $metaData['meta_title'],
            'meta_description' => $metaData['meta_description'],
            'meta_keywords' => $metaData['meta_keywords'],
        ]);
    }

   public function contact()
{
    $first_number = rand(1, 9);
    $second_number = rand(1, 9);

    Session::put('total_number', $first_number + $second_number);

    $getPages = Pages::getSlug('contact');
    $getSystemSettingApp = SystemSetting::getSingleRecord();

    return view('pages.contact', compact('getPages', 'getSystemSettingApp', 'first_number', 'second_number'));
}

public function submitContact(Request $request)
{
    $expectedAnswer = Session::get('total_number');

    if (empty($request->verification) || $expectedAnswer === null) {
        Session::flash('error', 'Please complete the verification to submit your message.');
        return redirect()->back();
    }

    if ((int) $request->verification !== $expectedAnswer) {
        Session::flash('error', 'Verification failed. Please try again.');
        return redirect()->back();
    }

    $contact = new ContactUs();
    if (Auth::check()) {
        $contact->user_id = Auth::id();
    }

    $contact->name = $request->name;
    $contact->email = $request->email;
    $contact->subject = $request->subject;
    $contact->message = $request->message;
    $contact->save();

    $getSystemSetting = SystemSetting::getSingleRecord();
    if (!empty($getSystemSetting->contact_email)) {
        Mail::to($getSystemSetting->contact_email)->send(new ContactUsMail($contact));
    }

    Session::flash('success', 'Your message has been sent successfully.');
    return redirect()->back();
}


    public function about()
    {
        $getPages = Pages::getSlug('about');

        return view('pages.about', compact('getPages'));
    }

    public function faq()
    {
        $getPages = Pages::getSlug('faq');

        return view('pages.faq', compact('getPages'));
    }

    public function paymentMethod()
    {
        $getPages = Pages::getSlug('payment-methods');
        return view('pages.payment_methods', compact('getPages'));
    }

    public function moneyBackGuarantee()
    {
        $getPages = Pages::getSlug('money-back-guarantee');

        return view('pages.money_back_guarantee', compact('getPages'));
    }

    public function return()
    {
        $getPages = Pages::getSlug('returns');

        return view('pages.returns', compact('getPages'));
    }

    public function shipping()
    {
        $getPages = Pages::getSlug('shipping');

        return view('pages.shipping', compact('getPages'));
    }

    public function termsCondition()
    {
        $getPages = Pages::getSlug('terms-and-conditions');

        return view('pages.terms_and_conditions', compact('getPages'));
    }

    public function privacyPolicy()
    {
        $getPages = Pages::getSlug('privacy-policy');

        return view('pages.privacy_policy', compact('getPages'));
    }
}
