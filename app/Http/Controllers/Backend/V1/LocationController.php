<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\Backend\V1\CountryModel;
use App\Models\Backend\V1\StatesModel;
use DB;

class LocationController
{
    public function countries_index(Request $request)
    {
        $getRecord = CountryModel::get();
        return view('backend.admin.countries.list', compact('getRecord'));
    }

    public function countries_add()
    {
        return view('backend.admin.countries.add');
    }

    public function countries_store(Request $request)
{
    // Validate request data
    $validatedData = $request->validate([
        'countries_name' => 'required|string|max:255|unique:countries,countries_name',
        'countries_code' => 'required|numeric|max_digits:10|unique:countries,countries_code'

    ]);

    // Save the country
    $save = new CountryModel;
    $save->countries_name = trim($validatedData['countries_name']);
    $save->countries_code = trim($validatedData['countries_code']);
    $save->save();

    return redirect()->route('countries')->with('success', "Country Successfully Added!");
}

public function countries_edit($id)
{
    $getRecord = CountryModel::find($id);

    // Check if record exists
    if (!$getRecord) {
        return redirect()->route('countries')->with('error', 'Country not found.');
    }

    return view('backend.admin.countries.edit', compact('getRecord'));
}

public function countries_update(Request $request, $id)
{
    $request->validate([
        'countries_name' => 'required|string|max:255',
        'countries_code' => 'required|numeric|max_digits:10|unique:countries,countries_code,' . $id,
    ]);

    $country = CountryModel::findOrFail($id);
    $country->update([
        'countries_name' => trim($request->countries_name),
        'countries_code' => trim($request->countries_code),
    ]);

        return redirect()->route('countries')->with('success', "Country Successfully Updated!");
    }

    public function countries_delete($id)
{
    // Find the country record
    $countryDelete = CountryModel::find($id);

    // Check if record exists
    if (!$countryDelete) {
        return redirect()->route('countries')->with('error', "Country not found!");
    }

    try {
        // Attempt to delete the record
        $countryDelete->delete();
        return redirect()->route('countries')->with('success', "Country Successfully Deleted!");
    } catch (\Exception $e) {
        // Handle unexpected errors
        return redirect()->route('countries')->with('error', "An error occurred while deleting the country.");
    }
}

// States Start

    public function states_index()
{
    $getRecord = StatesModel::select('states.*', 'countries.countries_name')
        ->join('countries', 'countries.id', '=', 'states.countries_id')
        ->orderBy('states.states_name', 'asc') // Ordering states alphabetically (A-Z)
        ->get();

    return view('backend.admin.states.list', compact('getRecord'));
}


     public function states_add(Request $request)
    {
        $getCountries = CountryModel::get();
        return view('backend.admin.states.add', compact('getCountries'));
    }

    public function states_store(Request $request)
{
    // Validate user input
    $request->validate([
        'countries_id' => 'required|exists:countries,id',
        'states_name' => 'required|string|max:255|unique:states,states_name',
    ]);

    // Trim input values
    $data = array_map('trim', $request->only(['countries_id', 'states_name']));

    // Save state
    $save = new StatesModel;
    $save->fill($data);

    if ($save->save()) {
        return redirect()->route('states')->with('success', "State Successfully Added!");
    }

    return redirect()->back()->with('error', "Failed to add state. Please try again.");
}

public function states_edit($id)
{
    $getRecord = StatesModel::find($id);

    // Check if state exists
    if (!$getRecord) {
        return redirect()->route('states')->with('error', "State not found!");
    }

    $getCountries = CountryModel::all(); 

    return view('backend.admin.states.edit', compact('getCountries', 'getRecord'));
}

public function states_update(Request $request, $id){
    $request->validate([
        'countries_id' => 'required|exists:countries,id',  // Ensure country exists
        'states_name' => 'required|string|max:255|unique:states,states_name,' . $id,  // Ensure uniqueness (excluding current ID)
    ]);

    // Fetch State or Fail
    $save = StatesModel::findOrFail($id);

    // Fill attributes and check if anything changed
    $save->fill([
        'countries_id' => trim($request->countries_id),
        'states_name' => trim($request->states_name),
    ]);

    // Only save if changes are detected
    if ($save->isDirty()) {
        $save->save();
        
        return redirect()->route('states')->with('success', "State Successfully Updated!");
    }

    return redirect()->route('states')->with('info', "No changes were made.");
}

public function states_delete($id)
{
    // Find the state or return 404 if not found
    $statesDelete = StateModel::findOrFail($id);

    // Use a transaction to ensure atomicity
    DB::transaction(function () use ($id, $statesDelete) {
        // Delete related cities first
        CityModel::where('states_id', $id)->delete();

        // Now delete the state
        $statesDelete->delete();
    });

    return redirect()->route('states')->with('success', 'Record Successfully Deleted!');
}

}
