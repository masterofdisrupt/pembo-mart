<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Partner;
use Str;

class PartnerController extends Controller
{
    public function index()
    {
        $getRecord = Partner::getRecord();
        return view('backend.admin.partners.list', compact('getRecord'));
    }

    public function add()
    {
        return view('backend.admin.partners.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_name' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_link' => 'nullable|url|max:255',
        ]);

        $partner = new Partner();
        $partner->button_link = trim($request->button_link ?? '');

        if ($request->hasFile('image_name')) {
            $image = $request->file('image_name');
            $imageName = Str::random(20).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('backend/upload/partners'), $imageName);
            $partner->image_name = trim($imageName);
        }

        $partner->status = trim($request->status);
        $partner->save();

        return redirect()->route('partner')->with('success', 'Partner created successfully.');
    }

    public function edit(Request $request, $id)
    {
        $getRecord = Partner::getSingleRecord($id);

        return view('backend.admin.partners.edit', compact('getRecord'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image_name' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  
            'button_link' => 'nullable|url|max:255',
        ]);

        $partner = Partner::getSingleRecord($id);
        $partner->button_link = trim($request->button_link ?? '');

        if ($request->hasFile('image_name')) {
            $image = $request->file('image_name');
            $imageName = Str::random(20).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('backend/upload/partners'), $imageName);
            $partner->image_name = trim($imageName);
        }

        $partner->status = trim($request->status);
        $partner->save();

        return redirect()->route('partner')->with('success', 'Partner updated successfully.');
    }

    public function delete($id)
    {
        $recordDelete = Partner::getSingleRecord($id);

        $recordDelete->is_delete = 1;
        $recordDelete->save();

        return redirect()->back()->with('error', "Record successfully deleted.");
    }

}
