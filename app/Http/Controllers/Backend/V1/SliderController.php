<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Slider;
use Str;

class SliderController extends Controller
{
    public function index()
    {
        $getRecord = Slider::getRecord();
        return view('backend.admin.slider.list', compact('getRecord'));
    }

    public function add()
    {
        return view('backend.admin.slider.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_name' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_name' => 'nullable|string|max:255',
            'button_link' => 'nullable|url|max:255',
        ]);

        $slider = new Slider();
        $slider->title = trim($request->title);
        $slider->button_name = trim($request->button_name ?? '');
        $slider->button_link = trim($request->button_link ?? '');

        if ($request->hasFile('image_name')) {
            $image = $request->file('image_name');
            $imageName = Str::random(20).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('backend/upload/sliders'), $imageName);
            $slider->image_name = trim($imageName);
        }

        $slider->status = trim($request->status);
        $slider->save();

        return redirect()->route('admin.slider')->with('success', 'Slider created successfully.');
    }

    public function edit(Request $request, $id)
    {
        $getRecord = Slider::getSingleRecord($id);

        return view('backend.admin.slider.edit', compact('getRecord'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_name' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_name' => 'nullable|string|max:255',
            'button_link' => 'nullable|url|max:255',
        ]);

        $slider = Slider::getSingleRecord($id);
        $slider->title = trim($request->title);
        $slider->button_name = trim($request->button_name ?? '');
        $slider->button_link = trim($request->button_link ?? '');

        if ($request->hasFile('image_name')) {
            $image = $request->file('image_name');
            $imageName = Str::random(20).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('backend/upload/sliders'), $imageName);
            $slider->image_name = trim($imageName);
        }

        $slider->status = trim($request->status);
        $slider->save();

        return redirect()->route('admin.slider')->with('success', 'Slider updated successfully.');
    }

    public function delete($id)
    {
        $recordDelete = Slider::getSingleRecord($id);

        $recordDelete->is_delete = 1;
        $recordDelete->save();

        return redirect()->back()->with('error', "Slider record successfully deleted.");
    }

}
