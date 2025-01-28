<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;

class AgentController
{
    public function AgentDashboard(Request $request)
    {
        return view('agent.index');
    }
}
