<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\Backend\V1\ProductModel;
use Exception;
use Auth;
use Str;




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

    $title = trim($request->title);
    $price = number_format((float) $request->price, 2, '.', '');
    $description = trim($request->description);

    // Generate a random 10-digit number for product code
    $productCode = mt_rand(1000000000, 9999999999);

    // Generate slug
    $slug = Str::slug($title, '-');

    // Check if the slug already exists
    if (ProductModel::where('slug', $slug)->exists()) {
        $slug .= '-' . uniqid(); // or use $slug .= '-' . Str::random(5);
    }

    // Save product details
    $product = new ProductModel;
    $product->title = $title;
    $product->price = $price;
    $product->product_code = $productCode;
    $product->description = $description;
    $product->created_by = Auth::id();
    $product->slug = $slug;
    $product->save();

    return redirect('admin/product/edit/' . $product->id)
           ->with('success', "Product Successfully Created");
}

 public function edit_product($product_id)
    {
        $product = ProductModel::getSingleRecord($product_id);
        if(!empty($product)){
            $data['product'] = $product;
            return view('backend.admin.product.edit', $data);
        } else {
            return redirect()->route('product')->with('error', "Product not found.");
        }
        
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
