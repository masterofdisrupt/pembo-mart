<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\Backend\V1\WeekModel;
use App\Models\Backend\V1\WeekTimeModel;
use App\Models\Backend\V1\UserTimeModel;
use Exception;
use Auth;


class UserTimeController
{
    public function week_list(Request $request)
    {
        $data['getRecord'] = WeekModel::get();
        return view('backend.admin.week.list', $data);
    }

    public function week_add(Request $request)
    {
        return view('backend.admin.week.add');
    }

    public function week_store(Request $request)
    {
        $save = new WeekModel;
        $save->name = trim($request->name);
        $save->save();

        return redirect(route('week.list'))->with('success', "Week Name Successfully Added.");
    }

     public function week_edit($id)
    {
        $data['getRecord'] = WeekModel::find($id);

         // Check if record exists to prevent errors
          if (!$data['getRecord']) {
            return redirect()->route('week.list')->with('error', "Record not found.");
        }

        return view('backend.admin.week.edit', $data);
    }

    public function week_update(Request $request, $id)
    {
        $request->validate([
        'name' => 'required|string|max:255',
    ]);

        $save = WeekModel::find($id);

        // Handle if the ID is not found
        if (!$save) {
        return redirect(route('week.list'))->with('error', "Record not found.");
    }

        $save->name = trim($request->name);
        $save->save();

        return redirect(route('week.list' ))->with('success', "Week Name Updated Successfully.");
    }

    public function week_delete($id)
{
    try {
        $week = WeekModel::findOrFail($id);
        
        // Check if user has any associated times
        if ($week->userTimes()->exists()) {
            return redirect()
                ->route('week.list')
                ->with('error', 'Cannot delete: This week has associated schedules.');
        }

        $week->delete();

        return redirect()
            ->route('week.list')
            ->with('success', 'Week deleted successfully.');
            
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()
            ->route('week.list')
            ->with('error', 'Week not found.');
            
    } catch (\Exception $e) {
        return redirect()
            ->route('week.list')
            ->with('error', 'Failed to delete week: ' . $e->getMessage());
    }
}

    // Week Time Start
    public function week_time_list(Request $request)
    {
        $data['getRecord'] = WeekTimeModel::getRecordAll();
        return view('backend.admin.week_time.list', $data);
    }

    public function week_time_add(Request $request)
    {
        return view('backend.admin.week_time.add');
    }

    public function week_time_store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
    ]);
    
        $save = new WeekTimeModel;
        $save->name = trim($request->name);
        $save->save();

        return redirect(route('week.time.list'))->with('success', "Week Time Added Successfully!");
    }

     public function week_time_edit($id)
    {
        $data['getRecord'] = WeekTimeModel::find($id);

        // Check if record exists to prevent errors
          if (!$data['getRecord']) {
            return redirect()->route('week.time.list')->with('error', "Record not found.");
        }

        return view('backend.admin.week_time.edit', $data);
    }

    public function week_time_update(Request $request, $id)
    {
        $request->validate([
        'name' => 'required|string|max:255',
    ]);
        $save = WeekTimeModel::find($id);

        // Handle if the ID is not found
        if (!$save) {
        return redirect(route('week.time.list'))->with('error', "Record not found.");
        }

        $save->name = trim($request->name);
        $save->save();

        return redirect(route('week.time.list'))->with('success', "Week Time Updated Successfully.");
    }
    
    public function week_time_delete($id)
{
    try {
        $weekTime = WeekTimeModel::findOrFail($id);

        $weekTime->delete();

        return redirect()
            ->route('week.time.list')
            ->with('success', 'Week time deleted successfully.');
            
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()
            ->route('week.time.list')
            ->with('error', 'Week time not found.');
            
    } catch (\Exception $e) {
        return redirect()
            ->route('week.time.list')
            ->with('error', 'Failed to delete week time: ' . $e->getMessage());
    }
}
     // Schedule Start
    public function admin_schedule(Request $request)
    {
        $data['weekRecord'] = WeekModel::get();
        $data['weekTimeRow'] = WeekTimeModel::get();
        $data['getRecord'] = UserTimeModel::get();


        return view('backend.admin.schedule.list', $data);
    }

    public function admin_schedule_update(Request $request)
    {
        // dd($request->all());
        // dd(Auth::user()->id);
        UserTimeModel::where('user_id', '=', Auth::user()->id)->delete();
        if (!empty($request->week)) {
            foreach ($request->week as $value) {
                if (!empty($value['status'])) {
                    $record = new UserTimeModel;
                    $record->week_id = trim($value['week_id']);
                    $record->user_id = Auth::user()->id;
                    $record->status = 1;
                    $record->start_time = trim($value['start_time']);
                    $record->end_time = trim($value['end_time']);
                    $record->save();
                }
            }
        }
        return redirect(route('admin.schedule'))->with('success', "Schedule Updated Successfully!");
    }
}
