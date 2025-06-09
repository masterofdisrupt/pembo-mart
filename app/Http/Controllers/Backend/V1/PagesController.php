<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Pages;
use App\Models\SystemSetting;
use App\Models\ContactUs;
use Str;

class PagesController extends Controller
{
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

        return redirect()->route('admin.pages')->with('success', 'Pages charge updated successfully.');
    }

    public function system_setting()
    {
        $getRecord = SystemSetting::getSingleRecord();

        return view('backend.admin.system.setting', compact('getRecord'));
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

        if(!empty($request->file('logo')))
        {
            $file = $request->file('logo');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move(public_path('backend/upload/setting/'), $filename);

            $save->logo = trim($filename);
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
