<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\V1\CategoryModel;
use Auth;
use Str;

class CategoryController extends Controller
{

    public function category_list()
    {
        $getRecord = CategoryModel::getRecords();
        return view('backend.admin.category.list', compact('getRecord'));
    }

    public function add_category(Request $request)
    {
        return view('backend.admin.category.add');
    }

    public function store_category(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        
        $category = new CategoryModel();
        $category->name = trim($request->name);
        $category->slug = trim($request->slug);
        $category->status = trim($request->status);
        $category->meta_title = trim($request->meta_title);
        $category->meta_description = trim($request->meta_description);
        $category->button_name = trim($request->button_name);
        $category->is_home = $request->has('is_home') ? 1 : 0;
        $category->is_menu = $request->has('is_menu') ? 1 : 0;


         if ($request->hasFile('image_name')) {
            $image = $request->file('image_name');
            $imageName = Str::random(20).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('backend/upload/category'), $imageName);
            $category->image_name = trim($imageName);
        }

        $category->created_by = auth()->user()->id;
        $category->save();

        return redirect()->route('category')->with('success', 'Category added successfully');
    }

    public function edit_category($id)
    {
        $getRecord = CategoryModel::getRecordById($id);
        return view('backend.admin.category.edit', compact('getRecord'));
    }

    public function update_category(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $category = CategoryModel::getRecordById($id);
        $category->name = trim($request->name);
        $category->slug = trim($request->slug);
        $category->status = trim($request->status);
        $category->meta_title = trim($request->meta_title);
        $category->meta_description = trim($request->meta_description);
        $category->meta_keywords = trim($request->meta_keywords);

        if ($request->hasFile('image_name')) {
            $image = $request->file('image_name');
            $imageName = Str::random(20).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('backend/upload/category'), $imageName);
            $category->image_name = trim($imageName);
        }

        $category->button_name = trim($request->button_name);
        $category->is_home = $request->has('is_home') ? 1 : 0;
        $category->is_menu = $request->has('is_menu') ? 1 : 0;

        $category->save();

        return redirect()->route('category')->with('success', 'Category updated successfully');
    }

    public function delete_category($id)
    {
        $category = CategoryModel::getRecordById($id);
        $category->is_delete = 1;
        $category->save();

        return redirect()->back()->with('success', 'Category deleted successfully');
    }

}
