<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\Backend\V1\WeekModel;


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

     public function week_delete($id, Request $request)
    {
        $save = WeekModel::find($id);
        $save->delete();

        return redirect(route('week.list'))->with('success', "Week Name Deleted Successfully.");
    }
}
