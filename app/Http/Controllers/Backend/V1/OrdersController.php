<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\V1\ProductModel;
use App\Models\Backend\V1\ColourModel;
use App\Models\Backend\V1\OrdersModel;
use App\Models\Backend\V1\OrdersDetailsModel;





class OrdersController
{
    public function list_orders(Request $request)
    {
        $getOrders = OrdersModel::getRecord($request); // update getRecord function with $request param
        return view('backend.admin.orders.list', compact('getOrders'));
    }


    public function add_orders(Request $request)
{
    $getProduct = ProductModel::all();
    $getColour = ColourModel::all();
    return view('backend.admin.orders.add', compact('getProduct', 'getColour'));
}


    public function store_orders(Request $request)
{
    // Validate request inputs
    $request->validate([
        'product_id' => 'required|exists:product,id', 
        'colour_id' => 'required|array',
        'qtys' => 'required|integer|min:1'
    ]);

    // Use database transactions to ensure data integrity
    DB::beginTransaction();

    try {
        // Create a new order using the `create` method
        $order = OrdersModel::create([
            'product_id' => filter_var($request->product_id, FILTER_SANITIZE_NUMBER_INT),
            'qtys' => filter_var($request->qtys, FILTER_SANITIZE_NUMBER_INT),
        ]);

        // Check if colour_ids are provided and bulk insert for efficiency
        if (!empty($request->colour_id)) {
            $orderDetails = [];
            foreach ($request->colour_id as $colour_id) {
                $orderDetails[] = [
                    'orders_id' => $order->id,
                    'colour_id' => $colour_id,
                    'created_at' => now(), // Timestamps for bulk insert
                    'updated_at' => now(),
                ];
            }
            OrdersDetailsModel::insert($orderDetails);
        }

        // Commit transaction if everything is successful
        DB::commit();

        return redirect()->route('orders')->with('success', "Order Successfully Created!");
    } catch (\Exception $e) {
        // Rollback transaction on error
        DB::rollBack();
        return redirect()->back()->with('error', "Something went wrong! Please try again.");
    }
}



    public function edit_orders($id)
{
    $getRecord = OrdersModel::findOrFail($id); // Throws 404 if not found
    $getProduct = ProductModel::all(); // Fetch all products
    $getColour = ColourModel::all(); // Fetch all colours
    $getOrderDetail = OrdersDetailsModel::where('orders_id', $id)->get(); // Get order details

    return view('backend.admin.orders.edit', compact('getProduct', 'getColour', 'getRecord', 'getOrderDetail'));
}


     public function update_orders(Request $request, $id)
{
    // Validate request inputs
    $request->validate([
        'product_id' => 'required|exists:product,id',
        'qtys' => 'required|integer|min:1',
        'colour_id' => 'nullable|array',
        'colour_id.*' => 'exists:colour,id'
    ]);

    // Find the order or fail
    $order = OrdersModel::findOrFail($id);

    // Update order
    $order->update([
        'product_id' => $request->product_id,
        'qtys' => $request->qtys,
    ]);

    // Sync order details (deletes old and inserts new)
    OrdersDetailsModel::where('orders_id', $id)->delete();
    
    if (!empty($request->colour_id)) {
        $orderDetails = [];
        foreach ($request->colour_id as $colour_id) {
            $orderDetails[] = [
                'orders_id' => $id,
                'colour_id' => $colour_id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        OrdersDetailsModel::insert($orderDetails);
    }

    // Redirect after updating
    return redirect()->route('orders')->with('success', "Order Successfully Updated!");
}

    public function delete_orders($id)
{
    // Use a transaction to ensure both deletions happen together
    DB::transaction(function () use ($id) {
        // Find and delete the main order (or fail if not found)
        $deleteRecord = OrdersModel::findOrFail($id);
        $deleteRecord->delete();

        // Delete all associated order details
        OrdersDetailsModel::where('orders_id', $id)->delete();
    });

    return redirect()->back()->with('success', "Order Successfully Deleted!");
}

}
