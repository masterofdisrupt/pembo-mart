<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class DashboardController
{
    public function dashboard(Request $request)
    {
        // $data['header_title'] = 'Dashboard';

        if (Auth::user()->role === 'admin') {
            // Fetch monthly data for customers
            $user = User::selectRaw('count(id) as count, DATE_FORMAT(created_at, "%Y-%m") as month')
                ->where('role', '=', 'user') // Only count customers with role = 'user'
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();

            $data['months'] = $user->pluck('month');
            $data['counts'] = $user->pluck('count');

            return view('backend.admin.index', $data);
        } elseif (Auth::user()->role === 'agent') {
            return view('backend.agent.index');
        } elseif (Auth::user()->role === 'user') {
            return view('backend.user.index', );
        }

        // Optional: Handle unexpected roles with an error or default view
        return redirect()->back()->with('error', 'Invalid role. Please contact support.');
    }



}
