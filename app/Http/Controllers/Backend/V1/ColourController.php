<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\Backend\V1\ColourModel;
use Exception;
use PDF;

class ColourController
{
    public function change_status(Request $request)
    {
        $item = ColourModel::find($request->id);

        if ($item) {
            $item->status = $request->status;
            $item->save();

            // Return a proper associative array for success
            return response()->json([
                'message' => 'Status Updated Successfully!'
            ]);
        } else {
            // Return a proper associative array for failure
            return response()->json([
                'message' => 'Status Not Found.'
            ], 404);
        }
    }

    public function colour_list(Request $request)
    {
        $colourRecord = ColourModel::getRecordAll($request);

        if (!$colourRecord) {
            return redirect()->back()->with('error', 'Colour Scheme not found.');
        }
        
        return view('backend.admin.colour.list', ['getRecord' => $colourRecord]);
    }

    public function add_colour(Request $request)
    {
        return view('backend.admin.colour.add');
    }

    public function store_colour(Request $request)
{
    // Validate input
    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:colour,name',
    ]);

    try {
        // Store colour in database
        $save = new ColourModel;
        $save->name = $validatedData['name'];
        $save->save();

        return redirect()->route('colour')->with("success", "Colour Successfully Added!");
    } catch (\Exception $e) {
        return redirect()->back()->with("error", "Something went wrong! Please try again.");
    }
}


   public function edit_colour($id)
{
    $colourRecord = ColourModel::findOrFail($id); // Automatically throws 404 if not found
    return view('backend.admin.colour.edit', ['getRecord' => $colourRecord]);
}


    public function update_colour($id, Request $request)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // Fetch record, automatically throws 404 if not found
    $save = ColourModel::findOrFail($id);

    // Update and save
    $save->name = trim($request->name);
    $save->save();

    return redirect()->route('colour')->with("success", "Colour Successfully Updated!");
}


    public function delete_colour($id)
{
    $save = ColourModel::find($id);

    if (!$save) {
        return redirect()->route('colour')->with('error', 'Colour not found.');
    }

    // Check for related products before deleting
    if ($save->product()->exists()) {
        return redirect()->route('colour')->with('error', 'Cannot delete: Colour is linked to products.');
    }

    $save->delete();

    return redirect()->route('colour')->with("success", "Colour Successfully Deleted!");
}

public function pdf()
    {
        $data = [
            'title' => 'Welcome To pembo-mart PDF. An Exciting Ride Awaits You.',
            'date' => date('m-d-Y')
        ];
        $pdf = PDF::loadView('pdf.pembo-martPDF', $data);

        return $pdf->download('Pembo-mart.pdf');
    }

    public function pdf_colour()
    {
        $getRecord = ColourModel::get();
        $data = [
            'title' => 'Show All Colour',
            'date' => date('m-d-Y'),
            'getRecord' => $getRecord
        ];

        $pdf = PDF::loadView('pdf.PDFColour', $data);
        return $pdf->download('colour.pdf');
    }

    public function pdf_by_id($id)
    {
        $getRecord = ColourModel::find($id);

        $data = [
            'title' => 'New PDF Download Pembo.org',
            'date' => date('d-m-Y'),
            'getRecord' => $getRecord
        ];

        $pdf = PDF::loadView('pdf.myColourPDF', $data);
        return $pdf->download('mycolour.pdf');
    }

}
