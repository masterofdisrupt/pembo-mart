<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Routing\Controller; 
use Illuminate\Http\Request;
use App\Models\Backend\V1\BlogModel;
use App\Models\Backend\V1\BlogCategoryModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Exception;
use Str;

class BlogController extends Controller 
{
   use AuthorizesRequests; 

    public function truncate()
    {
        $this->authorize('delete', BlogModel::class);

        try {
                BlogModel::truncate();
                return redirect()->back()->with('success', "All Blogs Deleted!");
        } catch (Exception $e) {
            return redirect()->back()->with('error', "An error occurred while deleting all blogs.");
        }
    }

    public function index(Request $request)
    {
        $getRecord = BlogModel::getRecords($request);
        return view('backend.admin.blog.list', compact('getRecord'));
    }

    public function create(Request $request)
    {
        $getCategory = BlogCategoryModel::getActiveRecords();
        return view('backend.admin.blog.add', compact('getCategory'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'blog_category_id' => 'required|exists:blog_category,id',
        'description' => 'required|string',
        'image_name' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
    ]);

    $meta = array_map('trim', [
        'title'            => $request->title,
        'meta_title'       => $request->meta_title,
        'meta_description' => $request->meta_description,
        'meta_keywords'    => $request->meta_keywords,
        'description'      => $request->description,
        'short_description'      => $request->short_description,
    ]);

    $slug = Str::slug($meta['title'], '-');
    if (BlogModel::where('slug', $slug)->exists()) {
        $slug .= '-' . time();
    }

    $blog = new BlogModel();
    $blog->title             = $meta['title'];
    $blog->meta_title        = $meta['meta_title'];
    $blog->meta_description  = $meta['meta_description'];
    $blog->meta_keywords     = $meta['meta_keywords'];
    $blog->description       = $meta['description'];
    $blog->short_description       = $meta['short_description'];
    $blog->blog_category_id  = $request->blog_category_id;
    $blog->status            = $request->status ? 1 : 0;
    $blog->slug              = $slug;

    if ($request->hasFile('image_name')) {
        $image = $request->file('image_name');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('backend/upload/blogs'), $imageName);
        $blog->image_name = $imageName;
    }

    $blog->save();

    return redirect()->route('blog')->with('success', 'Blog Successfully Created');
}

    public function view($id)
    {
        $getRecord = BlogModel::getSingleRecord($id);

        if (!$getRecord) {
            return redirect()->route('blog')->with('error', 'Blog post not found.');
        }

        return view('backend.admin.blog.view', compact('getRecord'));
    }  

    public function edit($id)
    {
        $getCategory = BlogCategoryModel::getActiveRecords();
        $getRecord = BlogModel::getSingleRecord($id);
        return view('backend.admin.blog.edit', compact('getRecord', 'getCategory'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_category,id',
            'description' => 'required|string',
            'image_name' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        $meta = array_map('trim', [
            'title'            => $request->title,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'description'      => $request->description,
            'short_description'      => $request->short_description,
        ]);


        $blog = BlogModel::getSingleRecord($id);
        if (!$blog) {
            return redirect()->route('blog')->with('error', "Blog not found!");
        }

        $blog->title             = $meta['title'];
        $blog->meta_title        = $meta['meta_title'];
        $blog->meta_description  = $meta['meta_description'];
        $blog->meta_keywords     = $meta['meta_keywords'];
        $blog->description       = $meta['description'];
        $blog->short_description       = $meta['short_description'];
        $blog->blog_category_id  = $request->blog_category_id;
        $blog->status            = $request->status ? 1 : 0;

        if ($request->hasFile('image_name')) {
            if ($blog->image_name && file_exists(public_path('backend/upload/blogs/' . $blog->image_name))) {
                unlink(public_path('backend/upload/blogs/' . $blog->image_name));
            }
            
            $image = $request->file('image_name');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('backend/upload/blogs'), $imageName);
            $blog->image_name = $imageName;
        }
       
        $blog->save();
        return redirect()->route('blog')->with('success', 'Blog Successfully Updated');
    }

     public function delete($id)
    {
        // Find the record
        $recordDelete = BlogModel::find($id);

        // Check if record exists
        if (!$recordDelete) {
            return redirect()->route('blog')->with('error', "Blog not found!");
        }

        try {
            // Delete record
            $recordDelete->delete();
            return redirect()->route('blog')->with('success', "Blog Successfully Deleted!");
        } catch (\Exception $e) {
            // Handle unexpected errors
            return redirect()->route('blog')->with('error', "An error occurred while deleting the blog.");
        }
    }
}