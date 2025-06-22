<?php

namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\V1\BlogCategoryModel;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $getRecord = BlogCategoryModel::getRecords();

        return view('backend.admin.blog_category.list', [
            'getRecord' => $getRecord,
        ]);
    }

    public function create()
    {
        return view('backend.admin.blog_category.add');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:blog_category,slug',
    ]);

    BlogCategoryModel::create([
        'title' => $request->title,
        'slug' => $request->slug,
        'meta_title' => $request->meta_title,
        'meta_description' => $request->meta_description,
        'meta_keywords' => $request->meta_keywords,
        'status' => $request->status,
    ]);

    return redirect()->route('blog.category')->with('success', 'Blog category created successfully.');
}


    public function edit($id)
    {
        $getRecord = BlogCategoryModel::getRecordById($id);

        return view('backend.admin.blog_category.edit', [
            'getRecord' => $getRecord,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_category,slug,' . $id,
        ]);

        $getRecord = BlogCategoryModel::getRecordById($id, $request->all());
        if (!$getRecord) {
            return redirect()->route('blog.category')->with('error', 'Blog category not found.');
        }
        $getRecord->update($request->all());

        return redirect()->route('blog.category')->with('success', 'Blog category updated successfully.');
    }

    public function destroy($id)
{
    $deleteRecord = BlogCategoryModel::getRecordById($id);

    if (!$deleteRecord) {
        return redirect()->route('blog.category')->with('error', 'Blog category not found.');
    }

    $deleteRecord->update(['is_delete' => 1]);

    return redirect()->route('blog.category')->with('success', 'Blog category deleted successfully.');
}

}
