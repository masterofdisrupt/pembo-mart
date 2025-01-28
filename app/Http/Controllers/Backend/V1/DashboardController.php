<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class DashboardController
{
    public function dashboard()
    {
        // $data['header_title'] = 'Dashboard';

        if (Auth::user()->role === 'admin') {
            return view('admin.index');
        } elseif (Auth::user()->role === 'agent') {
            return view('agent.index');
        } elseif (Auth::user()->role === 'user') {
            return view('user.index', );
        }

        // Optional: Handle unexpected roles with an error or default view
        return redirect()->back()->with('error', 'Invalid role. Please contact support.');
    }



}
