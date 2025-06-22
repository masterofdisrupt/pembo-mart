<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class DashboardController
{
    public function dashboard(Request $request)
    {

        if (Auth::user()->role === 'admin') {
            $user = User::selectRaw('count(id) as count, DATE_FORMAT(created_at, "%Y-%m") as month')
                ->where('role', '=', 'user') 
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

        return redirect()->back()->with('error', 'Invalid role. Please contact support.');
    }



}
