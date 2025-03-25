<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\V1\TransactionsModel;
use Auth;

class TransactionsController extends Controller
{
    public function transactions_index(Request $request)
    {
        // Build the base query with the relationship
        $query = TransactionsModel::with('user')
            ->where('transactions.is_delete', 0);

        // Apply filters dynamically
        if ($request->filled('id')) {
            $query->where('transactions.id', $request->id);
        }

        if ($request->filled('user_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_id . '%');
            });
        }

        if ($request->filled('order_number')) {
            $query->where('transactions.order_number', 'like', '%' . $request->order_number . '%');
        }

        if ($request->filled('transaction_id')) {
            $query->where('transactions.transaction_id', 'like', '%' . $request->transaction_id . '%');
        }

        if ($request->filled('amount')) {
            $query->where('transactions.amount', 'like', '%' . $request->amount . '%');
        }

        if ($request->filled('is_payment')) {
            $query->where('transactions.is_payment', $request->is_payment);
        }

        if ($request->filled('created_at')) {
            $query->whereDate('transactions.created_at', $request->created_at);
        }

        if ($request->filled('updated_at')) {
            $query->whereDate('transactions.updated_at', $request->updated_at);
        }

        // Execute the query with pagination
        $getRecord = $query->paginate(15);

        return view('backend.admin.transactions.list', compact('getRecord'));
    }

    // Agent Side Code
    public function agent_transactions_add(Request $request)
    {
        return view('backend.agent.transactions.add');
    }

        public function agent_transactions_store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'order_number' => 'required|string|max:255',
            'transaction_id' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'is_payment' => 'required|boolean',
        ]);

        // Create and save the transaction record
        $save = new TransactionsModel;
        $save->user_id = Auth::user()->id;
        $save->order_number = trim($request->order_number);
        $save->transaction_id = trim($request->transaction_id);
        $save->amount = trim($request->amount);
        $save->is_payment = trim($request->is_payment);
        $save->save();

        return redirect()->back()->with('success', 'Transaction Successfully Added!');
    }

    public function agent_transactions_list(Request $request)
    {
        $getRecord = TransactionsModel::getAgentRecord(Auth::user()->id);
        return view('backend.agent.transactions.list', compact('getRecord'));
    }

}

