<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Backend\V1\SupportsModel;
use App\Models\Backend\V1\SupportReplysModel;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;
use Auth;
use DB;

class SupportsController extends Controller
{
    /**
     * Display support tickets list
     *
     * @param Request $request
     * @return View
     */
    public function supports(Request $request): View
    {
        try {
            // Get cached statistics or compute them
            $statusCounts = Cache::remember('support_stats', 300, function () {
                return [
                    'total' => SupportsModel::count(),
                    'open' => SupportsModel::whereStatus(0)->count(),
                    'pending' => SupportsModel::whereStatus(2)->count(),
                    'closed' => SupportsModel::whereStatus(1)->count()
                ];
            });

            return view('backend.admin.supports.list', [
                'tickets' => SupportsModel::getSupportList($request),
                'users' => User::select('id', 'name', 'email')->orderBy('name')->get(),
                'statusCounts' => $statusCounts,
                'priorities' => SupportsModel::PRIORITIES,
                'statuses' => SupportsModel::STATUSES
            ]);

        } catch (\Exception $e) {
            Log::error('Support tickets error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('backend.admin.supports.list', [
                'tickets' => collect([]),
                'users' => collect([]),
                'statusCounts' => [
                    'total' => 0,
                    'open' => 0,
                    'pending' => 0,
                    'closed' => 0
                ],
                'error' => 'Failed to load support tickets. Please try again.'
            ]);
        }
    }


/**
 * Display support ticket reply form
 *
 * @param int $id
 * @return View|RedirectResponse
 */
public function support_reply(int $id): View|RedirectResponse
{
    try {
        $ticket = SupportsModel::with(['user', 'replies.user'])
            ->findOrFail($id);

        return view('backend.admin.supports.reply', [
            'ticket' => $ticket,
            'replies' => $ticket->replies()->latest()->paginate(10), // Fixed method name from reply() to replies()
            'priorities' => SupportsModel::PRIORITIES,
            'statuses' => SupportsModel::STATUSES
        ]);

    } catch (\Exception $e) {
        Log::error('Error loading support ticket:', [
            'ticket_id' => $id,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return back()
            ->with('error', 'Failed to load support ticket. Please try again.');
    }
}


/**
 * Update support ticket status
 *
 * @param Request $request
 * @return JsonResponse
 */
public function change_support_status(Request $request): JsonResponse
{
    try {
        // Validate request
        $validated = $request->validate([
            'id' => 'required|integer|exists:supports,id',
            'status' => 'required|integer|in:' . implode(',', array_keys(SupportsModel::STATUSES))
        ]);

        // Update ticket status
        $ticket = SupportsModel::findOrFail($validated['id']);
        
        // Check if status actually changed
        if ($ticket->status === $validated['status']) {
            return response()->json([
                'success' => true,
                'message' => 'Status already up to date'
            ]);
        }

        // Update status and log change
        $oldStatus = $ticket->status;
        $ticket->update(['status' => $validated['status']]);

        // Log status change
        Log::info('Support ticket status changed', [
            'ticket_id' => $ticket->id,
            'old_status' => SupportsModel::STATUSES[$oldStatus],
            'new_status' => SupportsModel::STATUSES[$validated['status']],
            'changed_by' => Auth::id()
        ]);

        // Clear cache
        Cache::forget('support_stats');

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'data' => [
                'ticket_id' => $ticket->id,
                'status' => $validated['status'],
                'status_label' => SupportsModel::STATUSES[$validated['status']],
                'status_color' => $ticket->status_color
            ]
        ]);

    } catch (ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        Log::error('Error updating support ticket status:', [
            'ticket_id' => $request->id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to update ticket status'
        ], 500);
    }
}

public function status_update($id, Request $request)
    {
        $product = DB::table('support')->select('status')->where('id', '=', $id)->first();

        if ($product) {
            $status = $product->status == '1' ? '0' : '1';

            DB::table('support')->where('id', $id)->update(['status' => $status]);

            return redirect()->back()->with('success', 'Support ticket status updated successfully.');
        }

        return redirect()->back()->with('error', 'Support ticket not found.');
    }

}


