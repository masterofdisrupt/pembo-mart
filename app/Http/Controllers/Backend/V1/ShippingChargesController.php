<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Backend\V1\ShippingChargesModel;

class ShippingChargesController extends Controller
{
    public function shipping_charges(Request $request)
    {
        $shippingCharges = ShippingChargesModel::getAllRecords($request);
        return view('backend.admin.shipping_charges.list', compact('shippingCharges'));
    }

    public function add_shipping_charges(Request $request)
    {
        return view('backend.admin.shipping_charges.add');
    }

    public function edit_shipping_charges(Request $request, $id)
    {
        $shippingCharges = ShippingChargesModel::findOrFail($id);
        return view('backend.admin.shipping_charges.edit', compact('shippingCharges'));
    }

    public function store_shipping_charges(Request $request)
    {
        $shippingCharge = new ShippingChargesModel();
        $shippingCharge->name = trim($request->input('name'));
        $shippingCharge->price = trim($request->input('price'));
        $shippingCharge->status = $request->input('status') ? 1 : 0;
        $shippingCharge->save();

        return redirect()->route('shipping.charge')->with('success', 'Shipping charge added successfully.');
    }

    public function update_shipping_charges(Request $request, $id)
    {
        $shippingCharge = ShippingChargesModel::findOrFail($id);
        $shippingCharge->name = trim($request->input('name'));
        $shippingCharge->price = trim($request->input('price'));
        $shippingCharge->status = $request->input('status') ? 1 : 0;
        $shippingCharge->save();

        return redirect()->route('shipping.charge')->with('success', 'Shipping charge updated successfully.');
    }

    public function delete_shipping_charges(Request $request, $id)
    {
        $shippingCharge = ShippingChargesModel::findOrFail($id);
        $shippingCharge->is_delete = 1;
        $shippingCharge->save();

        return redirect()->route('shipping.charge')->with('success', 'Shipping charge deleted successfully.');
    }
}
