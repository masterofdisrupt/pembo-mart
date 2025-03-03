<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\Backend\V1\ProductModel;
use Exception;



class ProductController
{
     public function list(Request $request)
    {
        $data['getRecord'] = ProductModel::get();
        return view('backend.admin.product.list', $data);
    }

    public function add_product(Request $request)
    {
        return view('backend.admin.product.add');
    }

     public function store_product(Request $request)
{
    // Validate the request
    $request->validate([
        'title'       => 'required|string|max:255',
        'price'       => 'required|numeric|min:0.01',
        'description' => 'required|string',
    ]);

    // Generate a random 10-digit number for product code
    $randNum = str_pad(mt_rand(1000000000, 9999999999), 10, '0', STR_PAD_LEFT);

    // Save product details
    $save = new ProductModel;
    $save->title = trim($request->title);
    $save->price = number_format((float) $request->price, 2, '.', '');
    $save->product_code = $randNum;
    $save->description = trim($request->description);
    $save->save();

    return redirect(route('product'))->with('success', "Product Successfully Added");
}

 public function edit_product($id)
    {
        $data['getRecord'] = ProductModel::find($id);
        return view('backend.admin.product.edit', $data);
    }

     public function update_product(Request $request, $id)
{
    // Validate request data
    $request->validate([
        'title' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
    ]);

    // Find the product by ID
    $product = ProductModel::find($id);

    if (!$product) {
        return redirect()->route('product')->with('error', "Product not found.");
    }

    // Update product details
    $product->title = trim($request->title);
    $product->price = number_format($request->price, 2, '.', ''); // Ensure valid price format
    $product->description = trim($request->description);
    
    // Preserve existing product_code instead of generating a new one
    $product->save();

    return redirect()->route('product')->with('success', "Product Successfully Updated");
}

public function delete_product($id, Request $request)
{
    $save = ProductModel::find($id);

    if (!$save) {
        return redirect()->route('product')->with('error', "Product not found.");
    }

    try {
        $save->delete();
        return redirect()->route('product')->with('success', "Product Deleted Successfully.");
    } catch (\Exception $e) {
        return redirect()->route('product')->with('error', "An error occurred while deleting the Product.");
    }
}

}
