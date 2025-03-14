<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\Backend\V1\CountryModel;

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
        'name' => 'required|string|max:255|unique:countries,name',
        'code' => 'required|string|max:10|unique:countries,code'
    ]);

    // Save the country
    $save = new CountryModel;
    $save->name = trim($validatedData['name']);
    $save->code = trim($validatedData['code']);
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
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:10|unique:countries,code,' . $id,
    ]);

    $country = CountryModel::findOrFail($id);
    $country->update([
        'name' => trim($request->name),
        'code' => trim($request->code),
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

}
