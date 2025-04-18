<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use App\Models\Backend\V1\ProductModel;
use App\Models\Backend\V1\CategoryModel;
use App\Models\Backend\V1\BrandsModel;
use App\Models\Backend\V1\ColourModel;
use App\Models\Backend\V1\SubCategoryModel;
use App\Models\Backend\V1\ProductColoursModel;
use App\Models\Backend\V1\ProductSizesModel;
use Exception;
use Auth;
use Str;




class ProductController
{
     public function list(Request $request)
    {
        $getRecord = ProductModel::getRecords();
        return view('backend.admin.product.list', compact('getRecord'));
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
            $data['getCategory'] = CategoryModel::getCategoryStatus();
            $data['getBrand'] = BrandsModel::getBrandStatus();
            $data['getColour'] = ColourModel::getColourStatus();

            $data['subcategories'] = SubCategoryModel::getRecordSubCategory($product->category_id);

            return view('backend.admin.product.edit', $data);
        } else {
            return redirect()->route('product')->with('error', "Product not found.");
        }
        
    }

     public function update_product(Request $request, $id)
{
    // dd($request->all());
    $request->validate([
        'title' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
    ]);

    // Find the product by ID
    $product = ProductModel::getSingleRecord($id);

    if (!$product) {
        return redirect()->back()->with('error', "Product not found.");
    }

    // Update product details
    $product->title = trim($request->title);
    $product->sku = trim($request->sku);
    $product->category_id = trim($request->category_id);
    $product->sub_category_id = trim($request->sub_category_id);
    $product->brand_id = trim($request->brand_id);
    $product->old_price = number_format($request->old_price, 2, '.', '');
    $product->price = number_format($request->price, 2, '.', ''); // Ensure valid price format
    $product->short_description = trim($request->short_description);
    $product->description = trim($request->description);
    $product->additional_info = trim($request->additional_info);
    $product->ship_and_returns = trim($request->ship_and_returns);
    $product->status = trim($request->status); 
    
    // Preserve existing product_code instead of generating a new one
    $product->save();

    ProductColoursModel::where('product_id', $id)->delete();
    if (!empty($request->colour_id)) {
        foreach ($request->colour_id as $key => $value) {
            $productColour = new ProductColoursModel();
            $productColour->product_id = $id;
            $productColour->colour_id = $value;
            $productColour->save();
        }
    }

    ProductSizesModel::where('product_id', $id)->delete();
    if (!empty($request->size)) {
        foreach ($request->size as $key => $value) {
            if(!empty($value['name']))
            {
                $productSize = new ProductSizesModel();
                $productSize->product_id = $id;
                $productSize->name = $value['name'];
                $productSize->price = !empty($value['price']) ? number_format($value['price'], 2, '.', '') : 0;
                $productSize->save();
            }
           
        }
    }
    // Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('uploads/product/' . $filename);
        Image::make($image)->resize(300, 300)->save($path);
        $product->image = 'uploads/product/' . $filename;
    }
    if ($request->hasFile('image1')) {
        $image1 = $request->file('image1');
        $filename1 = time() . '.' . $image1->getClientOriginalExtension();
        $path1 = public_path('uploads/product/' . $filename1);
        Image::make($image1)->resize(300, 300)->save($path1);
        $product->image1 = 'uploads/product/' . $filename1;
    }
    if ($request->hasFile('image2')) {
        $image2 = $request->file('image2');
        $filename2 = time() . '.' . $image2->getClientOriginalExtension();
        $path2 = public_path('uploads/product/' . $filename2);
        Image::make($image2)->resize(300, 300)->save($path2);
        $product->image2 = 'uploads/product/' . $filename2;
    }
    if ($request->hasFile('image3')) {
        $image3 = $request->file('image3');
        $filename3 = time() . '.' . $image3->getClientOriginalExtension();
        $path3 = public_path('uploads/product/' . $filename3);
        Image::make($image3)->resize(300, 300)->save($path3);
        $product->image3 = 'uploads/product/' . $filename3;
    }
    if ($request->hasFile('image4')) {
        $image4 = $request->file('image4');
        $filename4 = time() . '.' . $image4->getClientOriginalExtension();
        $path4 = public_path('uploads/product/' . $filename4);
        Image::make($image4)->resize(300, 300)->save($path4);
        $product->image4 = 'uploads/product/' . $filename4;
    }
    if ($request->hasFile('image5')) {
        $image5 = $request->file('image5');
        $filename5 = time() . '.' . $image5->getClientOriginalExtension();
        $path5 = public_path('uploads/product/' . $filename5);
        Image::make($image5)->resize(300, 300)->save($path5);
        $product->image5 = 'uploads/product/' . $filename5;
    }   

    return redirect()->back()->with('success', "Product Successfully Updated");
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
