<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Routing\Controller; // Correctly import the Controller class// Import the Controller class
use Illuminate\Http\Request;
use App\Models\Backend\V1\BlogModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Exception;

class BlogController extends Controller // Extend the Controller class
{
   use AuthorizesRequests; // Include the AuthorizesRequests trait

    public function blog_truncate()
    {
        // Ensure the user is authorized to perform this action
        $this->authorize('delete', BlogModel::class);

        try {
            // Truncate the blog table
            BlogModel::truncate();
            return redirect()->back()->with('success', "All Blogs Deleted!");
        } catch (Exception $e) {
            // Handle any errors that occur during the truncate operation
            return redirect()->back()->with('error', "An error occurred while deleting all blogs.");
        }
    }

    public function list_blog(Request $request)
    {
        $getRecord = BlogModel::getAllRecord($request);
        return view('backend.admin.blog.list', compact('getRecord'));
    }

    public function add_blog(Request $request)
    {
        return view('backend.admin.blog.add');
    }

    public function store_blog(Request $request)
    {
        // Validate request inputs
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog,slug',
            'description' => 'required|string'
        ]);

        // Create a new BlogModel instance
        $saveBlog = new BlogModel;
        $saveBlog->title = trim($validatedData['title']);
        $saveBlog->slug = trim($validatedData['slug']);
        $saveBlog->description = trim($validatedData['description']);
        $saveBlog->save();

        // Redirect with success message
        return redirect()->route('blogs')->with('success', 'Blog Successfully Added');
    }

    public function view_blog($id)
    {
        $getRecord = BlogModel::find($id);

        if (!$getRecord) {
            return redirect()->route('blogs')->with('error', 'Blog post not found.');
        }

        return view('backend.admin.blog.view', compact('getRecord'));
    }

    public function delete_blog($id)
    {
        // Find the record
        $recordDelete = BlogModel::find($id);

        // Check if record exists
        if (!$recordDelete) {
            return redirect()->route('blogs')->with('error', "Blog not found!");
        }

        try {
            // Delete record
            $recordDelete->delete();
            return redirect()->route('blogs')->with('success', "Record Successfully Deleted!");
        } catch (\Exception $e) {
            // Handle unexpected errors
            return redirect()->route('blogs')->with('error', "An error occurred while deleting the blog.");
        }
    }

    public function edit_blog(Request $request, $id)
    {
        $getRecord = BlogModel::find($id);
        return view('backend.admin.blog.edit', compact('getRecord'));
    }

    public function update_blog(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'description' => 'required'
        ]);

        // Find the blog post by ID
        $blog = BlogModel::find($id);

        // Check if the record exists
        if (!$blog) {
            return redirect()->route('blogs')->with('error', 'Blog not found.');
        }

        // Update blog details
        $blog->title = trim($request->title);
        $blog->slug = trim($request->slug);
        $blog->description = trim($request->description);
        $blog->save();

        return redirect()->route('blogs')->with('success', 'Blog Successfully Updated');
    }
}