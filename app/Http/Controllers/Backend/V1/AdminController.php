<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\RegisteredEmailMail;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; 
use Auth;
use Hash;
use Str;
use Mail;

class AdminController
{
    public function customer_list() 
    {
        $getRecord = User::getCustomer();
        return view('backend.admin.customer.list', compact('getRecord'));
    }

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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/', 
            'middle_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'surname' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/', 
            'username' => 'required|string|min:3|max:20|alpha_dash|unique:users,username,' . Auth::id(),
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(), 
            'phone' => 'nullable|string|regex:/^\+?[0-9]{7,15}$/', 
            'password' => 'nullable|string|min:8|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).+$/', 
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'about' => 'nullable|string|max:255', 
            'website' => 'nullable|url|max:255', 
        ]);


        
        $user = User::findOrFail(Auth::id());

        
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

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        if ($request->hasFile('photo')) {
            if (!empty($user->getProfile())) {
                unlink(public_path('backend/upload/profile/') . $user->photo);
            }

            $file = $request->file('photo');
            $filename = Str::random(30) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('backend/upload/profile/'), $filename);
            $user->photo = $filename;
        }
  
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profile Updated Successfully!');
    }


    public function users(Request $request)
    {
        $data['getRecord'] = User::getRecord($request);
        $data['TotalAdmin'] = User::where('role', '=', 'admin')->where('is_delete', '=', 0)->count();
        $data['TotalAgent'] = User::where('role', '=', 'agent')->where('is_delete', '=', 0)->count();
        $data['TotalUser'] = User::where('role', '=', 'user')->where('is_delete', '=', 0)->count();
        $data['TotalActive'] = User::where('status', '=', 'active')->where('is_delete', '=', 0)->count();
        $data['TotalInActive'] = User::where('status', '=', 'inactive')->where('is_delete', '=', 0)->count();
        $data['Total'] = User::where('is_delete', '=', 0)->count();
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
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/', 
            'username' => 'required|string|min:3|max:20|alpha_dash|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
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
    
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file)->resize(300, 300); // Resize to prevent distortion
            $image->save(public_path('backend/upload/profile/' . $filename));
           
            $user->photo = $filename;
        }

        $user->save();

        Mail::to($user->email)->send(new RegisteredEmailMail($user));

        return redirect(route('admin.users'))->with('success', "New account successfully created.");
    }

    public function admin_users_edit($id)
    {
        $getRecord = User::findOrFail($id);
        return view('backend.admin.users.edit', compact('getRecord'));
    }

  public function admin_users_edit_update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
        'username' => 'required|string|min:3|max:20|alpha_dash|unique:users,username,' . $id,
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'role' => 'required',
        'status' => 'required',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = User::find($id);
    if (!$user) {
        return back()->with('error', 'User not found.');
    }
    
    $user->name = trim($request->name);
    $user->middle_name = trim($request->middle_name);
    $user->surname = trim($request->surname);
    $user->username = trim($request->username);
    $user->email = trim($request->email);
    $user->phone = trim($request->phone);
    $user->role = trim($request->role);
    $user->status = trim($request->status);

    if ($request->hasFile('photo')) {
        if (!empty($user->photo) && file_exists(public_path('backend/upload/profile/' . $user->photo))) {
            unlink(public_path('backend/upload/profile/' . $user->photo));
        }

        $file = $request->file('photo');
        $randomStr = Str::random(30);
        $filename = $randomStr . '.' . $file->getClientOriginalExtension();

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file)->resize(300, 300); 
        $image->save(public_path('backend/upload/profile/' . $filename));

        $user->photo = $filename;
    }

    $user->save();

    return redirect(route('admin.users'))->with('success', "Record Successfully Updated.");
}

    public function admin_users_delete(Request $request, $id)
{
    $user = User::findOrFail($id);

    if ($user->id === Auth::id()) {
        return back()->with('error', 'You cannot delete your own account');
    }

    $user->is_delete = 1;
    $user->save();
    
    return redirect()
        ->back()
        ->with('success', 'Record successfully moved to trash');
}
    public function admin_users_update(Request $request)
    {
        $getRecord = User::find($request->input('edit_id'));
        $getRecord->name = $request->input('edit_name');
        $getRecord->middle_name = $request->input('edit_middle_name');
        $getRecord->surname = $request->input('edit_surname');
        $getRecord->save();
        $json['success'] = 'Data Updated Successfully';
        echo json_encode($json);
    }

    public function admin_users_changeStatus(Request $request)
    {
        $order = User::find($request->order_id);
        $order->status = $request->status_id;
        $order->save();
        $json['success'] = true;
        echo json_encode($json);
    }

    public function change_password(Request $request)
{
    return view('backend.admin.change_password.update');
}

public function update_password(Request $request)
{
    try {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'
            ]
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()
            ->route('admin.profile')
            ->with('success', 'Password changed successfully');

    } catch (\Exception $e) {
        return back()
            ->with('error', 'Failed to update password: ' . $e->getMessage());
    }
}

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $isExists = User::where('email', '=', $email)->first();

        if ($isExists) {
            return response()->json(array("exists" => true));
        } else {
            return response()->json(array("exists" => false));

        }
    }

    public function my_profile(Request $request)
    {
        $data['getRecord'] = User::find(Auth::user()->id);
        return view('backend.admin.profile', $data);
    }

    public function my_profile_update(Request $request)
    {
        $user = request()->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/', // Name can only contain letters and spaces
            'middle_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/', // Name can only contain letters and spaces
            'surname' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/', // Name can only contain letters and spaces
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(), // Valid email format
            'password' => 'nullable|string|min:8|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).+$/', // At least one uppercase, lowercase, number, and special character
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Only specific image formats allowed, size <= 2MB


        ]);

        $user = User::find(Auth::user()->id);
        $user->name = trim($request->name);
        $user->email = trim($request->email);

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if (!empty($request->file('photo'))) {
            $file = $request->file('photo');
            $randomStr = Str::random(30);
            $filename = $randomStr . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('backend/upload/profile/'), $filename);

            $user->photo = $filename;
        }

        $user->save();

        return redirect(route('admin.my.profile'))->with('success', "My Account Successfully Updated.");
    }

}
