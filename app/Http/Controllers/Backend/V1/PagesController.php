<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Pages;
use App\Models\SystemSetting;
use App\Models\HomeSetting;
use App\Models\ContactUs;
use App\Models\PaymentSetting;
use App\Models\Backend\V1\NotificationModel;
use Str;

class PagesController extends Controller
{
    public function notification()
    {
        $getRecord = NotificationModel::getRecord();
        return view('backend.admin.notification.list', compact('getRecord'));
    }

    public function index()
    {
        $getPages = Pages::getRecord();
        return view('backend.admin.pages.list', compact('getPages'));
    }

     public function edit(Request $request, $id)
    {
        $getPages = Pages::findOrFail($id);
        return view('backend.admin.pages.edit', compact('getPages'));
    }

    public function update(Request $request, $id)
    {
        $page = Pages::findOrFail($id);
        $page->name = trim($request->input('name'));
        $page->title = trim($request->input('title'));
        $page->description = trim($request->input('description'));
        $page->meta_title = trim($request->input('meta_title'));
        $page->meta_description = trim($request->input('meta_description'));
        $page->meta_keywords = trim($request->input('meta_keywords'));
        $page->save();

        if(!empty($request->file('image')))
        {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $randomStr = $page->id.Str::random(20);
            $filename = strtolower($randomStr). '.'.$ext;
            $file->move(public_path('backend/upload/pages/'), $filename);


            $page->image_name = trim($filename);
            $page->save();

        }

        return redirect()->route('admin.pages')->with('success', 'Page updated successfully.');
    }

    public function system_setting()
    {
        $getRecord = SystemSetting::getSingleRecord();

        return view('backend.admin.setting.system_setting', compact('getRecord'));
    }

    public function update_system_setting(Request $request)
    {
        $save = SystemSetting::getSingleRecord();
        $save->website = trim($request->website);
        $save->footer_desc = trim($request->footer_desc);
        $save->address = trim($request->address);
        $save->phone = trim($request->phone);
        $save->phone_two = trim($request->phone_two);
        $save->contact_email = trim($request->contact_email);
        $save->email = trim($request->email);
        $save->email_two = trim($request->email_two);
        $save->work_hour = trim($request->work_hour);
        $save->facebook_link = trim($request->facebook_link);
        $save->twitter_link = trim($request->twitter_link);
        $save->instagram_link = trim($request->instagram_link);
        $save->youtube_link = trim($request->youtube_link);
        $save->linkedin_link = trim($request->linkedin_link);

        if(!empty($request->file('logo_header')))
        {
            $file = $request->file('logo_header');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move(public_path('backend/upload/setting/'), $filename);

            $save->logo_header = trim($filename);
        }

        if(!empty($request->file('logo_footer')))
        {
            $file = $request->file('logo_footer');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move(public_path('backend/upload/setting/'), $filename);

            $save->logo_footer = trim($filename);
        }

        if(!empty($request->file('footer_payment_icon')))
        {
            $file = $request->file('footer_payment_icon');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move(public_path('backend/upload/setting/'), $filename);

            $save->footer_payment_icon = trim($filename);
        }

        if (!empty($request->file('favicon')))
        {
            $file = $request->file('favicon'); 
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move(public_path('backend/upload/setting/'), $filename);

            $save->favicon = trim($filename);
        }

        $save->save();

        return redirect()->back()->with('success', "Setting successfully updated");
    }

    public function home_setting(){
        $getRecord = HomeSetting::getSingleRecord();
        return view('backend.admin.setting.home_setting', compact('getRecord'));
    }

    public function update_home_setting(Request $request)
    {
        $save = HomeSetting::getSingleRecord();
        $save->trendy_product_title = trim($request->trendy_product_title);
        $save->shop_category_title = trim($request->shop_category_title);
        $save->recent_arrival_title = trim($request->recent_arrival_title);
        $save->blog_title = trim($request->blog_title);
        $save->payment_delivery_title = trim($request->payment_delivery_title);
        $save->payment_delivery_description = trim($request->payment_delivery_description);

        $save->refund_title = trim($request->refund_title);
        $save->refund_description = trim($request->refund_description);
        $save->support_title = trim($request->support_title);
        $save->support_description = trim($request->support_description);
        $save->signup_title = trim($request->signup_title);
        $save->signup_description = trim($request->signup_description);

        if(!empty($request->file('payment_delivery_image')))
        {
            $file = $request->file('payment_delivery_image');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move(public_path('backend/upload/setting/'), $filename);

            $save->payment_delivery_image = trim($filename);
        }
        if(!empty($request->file('refund_image')))
        {
            $file = $request->file('refund_image');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move(public_path('backend/upload/setting/'), $filename);

            $save->refund_image = trim($filename);
        }

        if(!empty($request->file('support_image')))
        {
            $file = $request->file('support_image');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move(public_path('backend/upload/setting/'), $filename);

            $save->support_image = trim($filename);
        }

        if(!empty($request->file('signup_image')))
        {
            $file = $request->file('signup_image');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move(public_path('backend/upload/setting/'), $filename);

            $save->signup_image = trim($filename);
        }
        
        $save->save();

        return redirect()->back()->with('success', "Home setting successfully updated");
    }

    public function payment_system()
    {
        $getRecord = PaymentSetting::getSingleRecord();
        return view('backend.admin.setting.payment_setting', compact('getRecord'));
    }

    public function update_payment_setting(Request $request)
    {
        $validated = $request->validate([
        'is_cash' => 'nullable|in:on',
        'is_wallet' => 'nullable|in:on',
    ]);

    $isCash = $request->has('is_cash') ? 1 : 0;
    $isWallet = $request->has('is_wallet') ? 1 : 0;

    $setting = PaymentSetting::firstOrNew();

    $setting->is_cash = $isCash;
    $setting->is_wallet = $isWallet;
    $setting->save();

    return redirect()->route('payment.setting')->with('success', 'Payment setting updated successfully.');
    }

    public function contactUs()
    {
        $getRecord = ContactUs::getRecord();
        return view('backend.admin.contactus.list', compact('getRecord'));
    }

    public function contactUsDelete($id)
    {
        ContactUs::where('id', '=', $id)->delete();

        return redirect()->back()->with('error', "Record successfully deleted");
    }
    
}
