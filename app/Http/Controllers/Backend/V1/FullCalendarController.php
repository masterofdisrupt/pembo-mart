<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Routing\Controller;
use App\Models\Backend\V1\EventsModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class FullCalendarController extends Controller 
{
    /**
     * Display calendar events or return events as JSON for AJAX requests
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    public function full_calendar(Request $request): View|JsonResponse
    {
        try {
            if ($request->ajax()) {
                // Validate request parameters
                $validated = $request->validate([
                    'start' => 'required|date',
                    'end' => 'required|date|after_or_equal:start'
                ]);

                $events = EventsModel::whereDate('start', '>=', $validated['start'])
                    ->whereDate('end', '<=', $validated['end'])
                    ->get(['id', 'title', 'start', 'end']);

                return response()->json($events);
            }

            return view('backend.admin.full_calendar.list');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to fetch calendar events'
                ], 500);
            }

            return view('backend.admin.full_calendar.list')
                ->with('error', 'Failed to load calendar');
        }
    }


     public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->type == 'add') {
                $event = EventsModel::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end
                ]);
                return response()->json($event);
            }
            if ($request->type == 'update') {
                $event = EventsModel::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end
                ]);
                return response()->json($event);
            }
            if ($request->type == 'delete') {
                $event = EventsModel::find($request->id)->delete();

                return response()->json($event);
            }
        }
    }
}
