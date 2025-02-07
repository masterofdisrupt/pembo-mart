<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\RegisteredEmailMail;
use Auth;
use Hash;
use Str;
use Mail;

class AdminController
{
    public function AdminDashboard(Request $request)
    {
        return view('backend.admin.index');
    }

    public function profile(Request $request)
    {
        $data['getRecord'] = User::find(Auth::user()->id);
        return view('backend.admin.admin_profile', $data);
    }

    public function profile_update(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/', // Name can only contain letters and spaces
            'middle_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/', // Name can only contain letters and spaces
            'surname' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/', // Name can only contain letters and spaces
            'username' => 'required|string|min:3|max:20|alpha_dash|unique:users,username,' . Auth::id(), // Alphanumeric, dashes, underscores
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(), // Valid email format
            'phone' => 'nullable|string|regex:/^\+?[0-9]{7,15}$/', // Optional, international phone number format
            'password' => 'nullable|string|min:8|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).+$/', // At least one uppercase, lowercase, number, and special character
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Only specific image formats allowed, size <= 2MB
            'address' => 'nullable|string|max:255', // Address string with max length
            'about' => 'nullable|string|max:255', // About section with max 255 characters
            'website' => 'nullable|url|max:255', // Valid URL format
        ]);


        // Find user
        $user = User::findOrFail(Auth::id());

        // Update basic fields
        $user->fill([
            'name' => $validatedData['name'],
            'middle_name' => $validatedData['middle_name'],
            'surname' => $validatedData['surname'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'about' => $validatedData['about'] ?? null,
            'website' => $validatedData['website'] ?? null,
        ]);

        // Update password if provided
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        // Handle file upload
        if ($request->hasFile('photo')) {
            if (!empty($user->getProfile())) {
                unlink(public_path('backend/upload/profile/') . $user->photo);
            }

            $file = $request->file('photo');
            $filename = Str::random(30) . '.' . $file->getClientOriginalExtension();

            // Store file securely
            $file->move(public_path('backend/upload/profile/'), $filename);
            $user->photo = $filename;
        }

        // Save user
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profile Updated Successfully!');
    }


    public function users(Request $request)
    {
        $data['getRecord'] = User::getRecord($request);
        // $data['TotalAdmin'] = User::where('role', '=', 'admin')->where('is_delete', '=', 0)->count();
        // $data['TotalAgent'] = User::where('role', '=', 'agent')->where('is_delete', '=', 0)->count();
        // $data['TotalUser'] = User::where('role', '=', 'user')->where('is_delete', '=', 0)->count();
        // $data['TotalActive'] = User::where('status', '=', 'active')->where('is_delete', '=', 0)->count();
        // $data['TotalInActive'] = User::where('status', '=', 'inactive')->where('is_delete', '=', 0)->count();
        // $data['Total'] = User::where('is_delete', '=', 0)->count();
        return view('backend.admin.users.list', $data);
    }

    public function view_users($id)
    {
        $data['getRecord'] = User::find($id);
        return view('backend.admin.users.view', $data);
    }

    public function admin_add_users(Request $request)
    {
        return view('backend.admin.users.add');
    }

    public function add_users_store(Request $request)
    {
        $user = request()->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/', // Name can only contain letters and spaces
            'username' => 'required|string|min:3|max:20|alpha_dash|unique:users,username', // Alphanumeric, dashes, underscores
            'email' => 'required|email|max:255|unique:users,email', // Valid email format
            'role' => 'required',
            'status' => 'required',
        ]);

        $user = new User;
        $user->name = trim($request->name);
        $user->middle_name = trim($request->middle_name);
        $user->surname = trim($request->surname);
        $user->username = trim($request->username);
        $user->email = trim($request->email);
        $user->phone = trim($request->phone);
        $user->role = trim($request->role);
        $user->status = trim($request->status);
        $user->remember_token = Str::random(50);

        if (!empty($request->file('photo'))) {
            $file = $request->file('photo');
            $randomStr = Str::random(30);
            $filename = $randomStr . '.' . $file->getClientOriginalExtension();
            $file->move('upload/', $filename);
            $user->photo = $filename;
        }
        $user->save();

        Mail::to($user->email)->send(new RegisteredEmailMail($user));

        return redirect(route('admin.users'))->with('success', "New account successfully created.");
    }

}
