<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\Backend\V1\ComposeEmailModel;
use Auth;

class AgentController
{
    public function AgentDashboard(Request $request)
    {
        return view('backend.agent.index');
    }

    public function agent_email_inbox(Request $request)
    {
        // Count sent emails where 'is_sent' is 0
        $sentEmailsCount = ComposeEmailModel::where('is_sent', 0)->count();

        $data['getRecord'] = ComposeEmailModel::getAgentRecord(Auth::user()->id);

          // Pass both the count and records to the view
        $data['sentEmailsCount'] = $sentEmailsCount;
        return view('backend.agent.email.inbox', $data);
    }
}
