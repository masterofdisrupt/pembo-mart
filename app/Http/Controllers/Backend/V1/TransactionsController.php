<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Backend\V1\TransactionsModel;
use Auth;

class TransactionsController extends Controller
{
    /**
 * Delete the specified transaction
 *
 * @param int $id
 * @return \Illuminate\Http\RedirectResponse
 */
public function destroy($id)
{
    try {
        $transaction = TransactionsModel::findOrFail($id);
        
        $transaction->delete();

        return redirect()
            ->back()
            ->with('success', 'Transaction deleted successfully.');
            
    } catch (ModelNotFoundException $e) {
        return redirect()
            ->back()
            ->with('error', 'Transaction not found.');
            
    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->with('error', 'Failed to delete transaction.');
    }
}
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

    /**
 * Show the form for editing the specified transaction
 *
 * @param int $id
 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
 */

public function transactions_edit($id)
{
    try {
        $transaction = TransactionsModel::findOrFail($id);
        
        return view('backend.admin.transactions.edit', [
            'getRecord' => $transaction
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()
            ->route('transactions')
            ->with('error', 'Transaction not found.');
    } catch (\Exception $e) {
        return redirect()
            ->route('transactions')
            ->with('error', 'Failed to load transaction.');
    }
}

/**
 * Update the specified transaction in storage.
 *
 * @param int $id
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\RedirectResponse
 */

public function transactions_update(Request $request, $id)
{
    try {
        // Find the transaction or fail
        $transaction = TransactionsModel::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'order_number' => 'required|string|max:255',
            'transaction_id' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'is_payment' => 'required|boolean',
        ]);

        // Update the transaction
        $transaction->update([
            'order_number' => trim($validatedData['order_number']),
            'transaction_id' => trim($validatedData['transaction_id']),
            'amount' => $validatedData['amount'],
            'is_payment' => $validatedData['is_payment'],
        ]);

        return redirect()
            ->route('transactions')
            ->with('success', 'Transaction successfully updated.');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()
            ->route('transactions')
            ->with('error', 'Transaction not found.');
    } catch (\Exception $e) {
        return redirect()
            ->route('transactions')
            ->with('error', 'Failed to update transaction.');
    }
}

    /**
 * Soft delete the specified transaction
 *
 * @param int $id
 * @return \Illuminate\Http\RedirectResponse
 */
public function transactions_delete($id)
{
    try {
        $transaction = TransactionsModel::findOrFail($id);
        
        // Soft delete the transaction
        
        $transaction->is_delete = 1;
        $transaction->save();

        return redirect()
            ->back()
            ->with('success', 'Transaction successfully deleted.');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()
            ->back()
            ->with('error', 'Transaction not found.');
    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->with('error', 'Failed to delete transaction.');
    }
}

}

