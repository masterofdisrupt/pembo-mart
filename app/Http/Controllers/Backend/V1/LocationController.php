<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\Backend\V1\CountryModel;
use App\Models\Backend\V1\StateModel;
use App\Models\Backend\V1\CityModel;
use App\Models\Backend\V1\AddressModel;
use DB;

class LocationController
{
    public function countries_index(Request $request)
    {
        $getRecord = CountryModel::where('countries.is_delete', 0)->get();
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
        'country_name' => 'required|string|max:255|unique:countries,country_name',
        'country_code' => 'required|numeric|max_digits:10|unique:countries,country_code'

    ]);

    // Save the country
    $save = new CountryModel;
    $save->country_name = trim($validatedData['country_name']);
    $save->country_code = trim($validatedData['country_code']);
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
        'country_name' => 'required|string|max:255',
        'country_code' => 'required|numeric|max_digits:10|unique:countries,country_code,' . $id,
    ]);

    $country = CountryModel::findOrFail($id);
    $country->update([
        'country_name' => trim($request->country_name),
        'country_code' => trim($request->country_code),
    ]);

        return redirect()->route('countries')->with('success', "Country Successfully Updated!");
    }
    
    public function countries_delete($id)
{
    try {
        // Start a transaction
        DB::beginTransaction();

        // Find the country record
        $countryDelete = CountryModel::find($id);

        if (!$countryDelete) {
            return redirect()->route('countries')->with('error', "Country not found!");
        }

        // Mark as deleted (soft delete flag)
        $countryDelete->is_delete = 1;
        $countryDelete->save(); // Save changes

        // Mark related states and cities as deleted
        StateModel::where('country_id', $id)->update(['is_delete' => 1]);
        CityModel::where('country_id', $id)->update(['is_delete' => 1]);

        // Commit transaction
        DB::commit();

        return redirect()->route('countries')->with('success', "Country Successfully Deleted!");
    } catch (\Exception $e) {
        // Rollback transaction in case of error
        DB::rollBack();
        return redirect()->route('countries')->with('error', "An error occurred while deleting the country.");
    }
}


// States Start

    public function states_index()
{
    $getRecord = StateModel::select('states.*', 'countries.country_name')
        ->join('countries', 'countries.id', '=', 'states.country_id')
        ->where('states.is_delete', 0)
        ->orderBy('states.id', 'asc')
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
        'country_id' => 'required|exists:countries,id',
        'state_name' => 'required|string|max:255|unique:states,state_name',
    ]);

    // Trim input values
    $data = array_map('trim', $request->only(['country_id', 'state_name']));

    // Save state
    $save = new StateModel;
    $save->fill($data);

    if ($save->save()) {
        return redirect()->route('states')->with('success', "State Successfully Added!");
    }

    return redirect()->back()->with('error', "Failed to add state. Please try again.");
}

public function states_edit($id)
{
    $getRecord = StateModel::find($id);

    // Check if state exists
    if (!$getRecord) {
        return redirect()->route('states')->with('error', "State not found!");
    }

    $getCountries = CountryModel::all(); 

    return view('backend.admin.states.edit', compact('getCountries', 'getRecord'));
}

public function states_update(Request $request, $id){
    $request->validate([
        'country_id' => 'required|exists:countries,id',  // Ensure country exists
        'state_name' => 'required|string|max:255|unique:states,state_name,' . $id,  // Ensure uniqueness (excluding current ID)
    ]);

    // Fetch State or Fail
    $save = StateModel::findOrFail($id);

    // Fill attributes and check if anything changed
    $save->fill([
        'country_id' => trim($request->country_id),
        'state_name' => trim($request->state_name),
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
        CityModel::where('state_id', $id)->update(['is_delete' => 1]);

        // Now delete the state
        $statesDelete->is_delete = 1;
        $statesDelete->save();
    });

    return redirect()->route('states')->with('success', 'State Successfully Deleted!');
}

// Cities start
    public function cities_index(Request $request)
    {
        $getRecord = CityModel::getJoinedRecord($request);
        return view('backend.admin.cities.list', compact('getRecord'));
    }

    public function cities_add(Request $request)
    {
        // Fetch country records
         $getCountries = CountryModel::all(); 
          if ($getCountries->isEmpty()) {
        return redirect()->back()->with('error', 'No countries found.');
    }
    
        return view('backend.admin.cities.add', compact('getCountries'));
    }

    public function get_state_name($countryId, Request $request)
    {
        $states = StateModel::where('country_id', $countryId)->get();
        return response()->json($states);
    }

    public function cities_store(Request $request)
{
    // Validate user input
    $request->validate([
        'country_id' => 'required|exists:countries,id',
        'state_id' => 'required|exists:states,id',
        'city_name' => 'required|string|max:255|unique:cities,city_name,NULL,id,state_id,' . $request->state_id,
    ]);

    // Create and save the city record
    $save = new CityModel;
    $save->country_id = trim($request->country_id);
    $save->state_id = trim($request->state_id);
    $save->city_name = trim($request->city_name);

    if ($save->save()) {
        return redirect()->route('cities')->with('success', "City Successfully Added!");
    }

    return redirect()->back()->with('error', "Failed to add city. Please try again.");
}

public function cities_edit(Request $request, $id)
{
    $getRecord = CityModel::findOrFail($id); // Automatically handles missing record

    $getCountries = CountryModel::select('id', 'country_name')->get(); // Fetch only required columns
    $getStateRecord = StateModel::where('country_id', $getRecord->country_id)->get(); // Get states for the selected country

    return view('backend.admin.cities.edit', compact('getStateRecord', 'getCountries', 'getRecord'));
}

public function cities_update(Request $request, $id)
{
    // Validate Input
    $request->validate([
        'country_id' => 'required|exists:countries,id',
        'state_id' => 'required|exists:states,id',
        'city_name' => 'required|string|max:255'
    ]);

    // Find City Record
    $save = CityModel::find($id);
    if (!$save) {
        return redirect()->route('cities')->with('error', 'City not found!');
    }
    // Update Record Using Mass Assignment
    $save->update($request->only(['country_id', 'state_id', 'city_name']));

    return redirect()->route('cities')->with('success', 'City Successfully Updated!');
}

public function cities_delete($id)
    {
        $cityRecord = CityModel::find($id);

        if (!$cityRecord) {
        return redirect()->route('cities')->with('error', 'City not found!');
    }
        $cityRecord->is_delete = 1;
        $cityRecord->save();

        return redirect()->route('cities')->with('success', 'City Successfully Deleted!');
    }

    // Address menu start
    public function admin_address(Request $request)
    {
        $getRecord = AddressModel::getRecordAll($request);
        return view('backend.admin.address.list', compact('getRecord'));
    }

    public function admin_address_add(Request $request)
    {
        $getRecord = CountryModel::get();
        return view('backend.admin.address.add', compact('getRecord'));
    }

    public function get_states($id)
    {
        $states = StateModel::where('countries_id', $id)->get();
        return response()->json($states);
    }

    public function get_cities($id)
    {
        $cities = CityModel::where('state_id', $id)->get();
        return response()->json($cities);
    }

    public function admin_address_store(Request $request)
{
    // Validate the request data
    $request->validate([
        'country_id' => 'required|exists:countries,id',
        'state_id' => 'required|exists:states,id',
        'city_id' => 'required|exists:cities,id',
        'address' => 'required|string|max:255|unique:address,address',
        'zip_code' => 'required|numeric|digits_between:1,10', // To validate the length of a numeric input, use the digits rule.
    ]);

    // Create and save the address record using mass assignment
    $save = new AddressModel;
    $save->fill([
        'country_id' => trim($request->country_id),
        'state_id' => trim($request->state_id),
        'city_id' => trim($request->city_id),
        'address' => trim($request->address),
        'zip_code' => trim($request->zip_code),
    ]);

    if ($save->save()) {
        return redirect()->route('admin.address')->with('success', 'Address Successfully Added!');
    }

    return redirect()->back()->with('error', 'Failed to add address. Please try again.');
}

public function admin_address_edit($id)
{
    // Fetch the address record
    $addressRecord = AddressModel::find($id);

    // Check if the address record exists
    if (!$addressRecord) {
        return redirect()->route('admin.address')->with('error', 'Address not found.');
    }

    // Fetch related data
    $countries = CountryModel::select('id', 'country_name')->get();
    $states = StateModel::where('country_id', $addressRecord->country_id)->select('id', 'state_name')->get();
    $cities = CityModel::where('state_id', $addressRecord->state_id)->select('id', 'city_name')->get();

    // Pass data to the view
    return view('backend.admin.address.edit', [
        'getRecord' => $countries,
        'getRecordAdd' => $addressRecord,
        'getState' => $states,
        'getCity' => $cities,
    ]);
}

public function admin_address_update($id, Request $request)
{
    // Validate the request data
    $request->validate([
        'country_id' => 'required|exists:countries,id',
        'state_id' => 'required|exists:states,id',
        'city_id' => 'required|exists:cities,id',
        'address' => 'required|string|max:255|unique:address,address,' . $id,
        'zip_code' => 'required|numeric|digits_between:1,10',
    ]);

    // Find the address record
    $save = AddressModel::find($id);

    // Check if the address record exists
    if (!$save) {
        return redirect()->route('admin.address')->with('error', 'Address not found.');
    }

    // Update the address record using mass assignment
    $save->fill([
        'country_id' => trim($request->country_id),
        'state_id' => trim($request->state_id),
        'city_id' => trim($request->city_id),
        'address' => trim($request->address),
        'zip_code' => trim($request->zip_code),
    ]);

    // Only save if changes are detected
    if ($save->isDirty()) {
        $save->save();
        return redirect()->route('admin.address')->with('success', 'Address Successfully Updated!');
    }

    return redirect()->route('admin.address')->with('info', 'No changes were made.');
}

public function admin_address_delete($id)
{
    // Find the address record
    $addressDelete = AddressModel::find($id);

    // Check if the address record exists
    if (!$addressDelete) {
        return redirect()->route('admin.address')->with('error', 'Record not found.');
    }

    // Delete the address record
    $addressDelete->is_delete = 1;
    $addressDelete->save();

    return redirect()->route('admin.address')->with('success', 'Address Successfully Deleted!');
}

}
