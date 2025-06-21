<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\V1\ProductModel;
use App\Models\Backend\V1\ColourModel;
use App\Models\Backend\V1\OrdersModel;
use App\Models\Backend\V1\NotificationModel;
use App\Models\Backend\V1\OrdersDetailsModel; 
use App\Mail\OrderStatusMail;
use Mail;





class OrdersController
{
    public function update_order_status(Request $request)
    {
        $request->validate([
            'status' => 'required|in:0,1,2,3,4',
            'id' => 'required|exists:orders,id'
        ]);


        $order = OrdersModel::getSingleRecord($request->id);
        $order->status = $request->status;
        $order->save();

        $user_id = 1;
        $url = route('user.orders');
        $message = "Order status has been updated to " . $order->status . " for order #" . $order->order_number;
        
        NotificationModel::sendNotification($user_id, $url, $message);

        if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(new OrderStatusMail($order));
            } else {
                \Log::warning('User not found or missing email for order ID: ' . $order->id);
            }

    
       return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully!',
        ]);

    }

    public function list_orders(Request $request)
    {
        $getOrders = OrdersModel::getRecord($request);
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
    $request->validate([
        'product_id' => 'required|exists:product,id', 
        'colour_id' => 'required|array',
        'qtys' => 'required|integer|min:1'
    ]);

    DB::beginTransaction();

    try {
        $order = OrdersModel::create([
            'product_id' => filter_var($request->product_id, FILTER_SANITIZE_NUMBER_INT),
            'qtys' => filter_var($request->qtys, FILTER_SANITIZE_NUMBER_INT),
        ]);

        if (!empty($request->colour_id)) {
            $orderDetails = [];
            foreach ($request->colour_id as $colour_id) {
                $orderDetails[] = [
                    'orders_id' => $order->id,
                    'colour_id' => $colour_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            OrdersDetailsModel::insert($orderDetails);
        }

        DB::commit();

        return redirect()->route('orders')->with('success', "Order Successfully Created!");
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', "Something went wrong! Please try again.");
    }
}



    public function edit_orders($id)
{
    $getRecord = OrdersModel::findOrFail($id);
    $getProduct = ProductModel::all();
    $getColour = ColourModel::all();
    $getOrderDetail = OrdersDetailsModel::where('orders_id', $id)->get(); // Get order details

    return view('backend.admin.orders.edit', compact('getProduct', 'getColour', 'getRecord', 'getOrderDetail'));
}


     public function update_orders(Request $request, $id)
{
    $request->validate([
        'product_id' => 'required|exists:product,id',
        'qtys' => 'required|integer|min:1',
        'colour_id' => 'nullable|array',
        'colour_id.*' => 'exists:colour,id'
    ]);

    $order = OrdersModel::findOrFail($id);

    $order->update([
        'product_id' => $request->product_id,
        'qtys' => $request->qtys,
    ]);

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

    return redirect()->route('orders')->with('success', "Order Successfully Updated!");
}

    public function delete_orders($id)
{
    DB::transaction(function () use ($id) {
        $deleteRecord = OrdersModel::findOrFail($id);
        $deleteRecord->delete();
        OrdersDetailsModel::where('orders_id', $id)->delete();
    });

    return redirect()->back()->with('success', "Order Successfully Deleted!");
}

public function view_orders($id, Request $request)
{
    if ($request->filled('notif_id')) {
    $notification = NotificationModel::find($request->notif_id);
    
    if ($notification) {
        $notification->update(['is_read' => 1]);
    }
}


    $getRecord = OrdersModel::getSingleRecord($id);

    return view('backend.admin.orders.view', compact('getRecord'));

}

}
