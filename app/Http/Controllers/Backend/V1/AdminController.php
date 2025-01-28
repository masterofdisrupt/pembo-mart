<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;

class AdminController
{
    public function AdminDashboard(Request $request)
    {
        return view('admin.index');
    }

    public function admin_users(Request $request)
    {
        // $data['getRecord'] = User::getRecord($request);
        // $data['TotalAdmin'] = User::where('role', '=', 'admin')->where('is_delete', '=', 0)->count();
        // $data['TotalAgent'] = User::where('role', '=', 'agent')->where('is_delete', '=', 0)->count();
        // $data['TotalUser'] = User::where('role', '=', 'user')->where('is_delete', '=', 0)->count();
        // $data['TotalActive'] = User::where('status', '=', 'active')->where('is_delete', '=', 0)->count();
        // $data['TotalInActive'] = User::where('status', '=', 'inactive')->where('is_delete', '=', 0)->count();
        // $data['Total'] = User::where('is_delete', '=', 0)->count();
        return view('admin.users.list');
    }
}
