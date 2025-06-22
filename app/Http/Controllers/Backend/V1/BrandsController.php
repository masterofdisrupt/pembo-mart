<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Backend\V1\BrandsModel;
use Auth;

class BrandsController extends Controller
{
    public function index(Request $request)
    {
        $getRecord = BrandsModel::getRecords();
        return view('backend.admin.brands.list', compact('getRecord'));
    }

    public function create(Request $request)
    {
        return view('backend.admin.brands.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug',
        ]);

        $brand = new BrandsModel();
        $brand->name = trim($request->name);
        $brand->slug = trim($request->slug);
        $brand->status = trim($request->status);
        $brand->meta_title = trim($request->meta_title);
        $brand->meta_description = trim($request->meta_description);
        $brand->meta_keywords = trim($request->meta_keywords);
        $brand->created_by = Auth::user()->id;
        $brand->save();

        return redirect()->route('brands')->with('success', 'Brand created successfully.');
    }

    public function edit(Request $request, $id)
    {
        $getRecord = BrandsModel::getBrandById($id);
        if (!$getRecord) {
            return redirect()->route('brands')->with('error', 'Brand not found.');
        }
        return view('backend.admin.brands.edit', compact('getRecord'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug,' . $id,
        ]);

        $brand = BrandsModel::getBrandById($id);
        if (!$brand) {
            return redirect()->route('brands')->with('error', 'Brand not found.');
        }

        $brand->name = trim($request->name);
        $brand->slug = trim($request->slug);
        $brand->status = trim($request->status);
        $brand->meta_title = trim($request->meta_title);
        $brand->meta_description = trim($request->meta_description);
        $brand->meta_keywords = trim($request->meta_keywords);
        $brand->save();

        return redirect()->route('brands')->with('success', 'Brand updated successfully.');
    }

    public function delete(Request $request, $id)
    {
        $brand = BrandsModel::getBrandById($id);
        if (!$brand) {
            return redirect()->route('brands')->with('error', 'Brand not found.');
        }

        $brand->is_delete = 1;
        $brand->save();

        return redirect()->route('brands')->with('success', 'Brand moved to trash.');
    }
}
