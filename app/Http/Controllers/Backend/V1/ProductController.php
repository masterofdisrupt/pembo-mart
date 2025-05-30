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
use App\Models\Backend\V1\ProductImagesModel;
use Illuminate\Http\RedirectResponse;
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
    $request->validate([
        'title'       => 'required|string|max:255',
        'price'       => 'required|numeric|min:0.01',
        'description' => 'required|string',
    ]);

    $title = trim($request->title);
    $price = number_format((float) $request->price, 2, '.', '');
    $description = trim($request->description);
 
    $productCode = mt_rand(1000000000, 9999999999);

    $slug = Str::slug($title, '-');

    if (ProductModel::where('slug', $slug)->exists()) {
        $slug .= '-' . uniqid(); 
    }

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



/**
 * Update the specified product
 *
 * @param Request $request
 * @param int $id
 * @return \Illuminate\Http\RedirectResponse
 */
    public function update_product(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sku' => 'required|string|unique:product,sku,' . $id,
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'additional_info' => 'nullable|string',
            'ship_and_returns' => 'nullable|string',
            'status' => 'required|in:0,1',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'colour_id.*' => 'nullable|exists:colour,id',
            'size.*.name' => 'nullable|string|max:50',
            'size.*.price' => 'nullable|numeric|min:0'
        ]);

       $product = ProductModel::getSingleRecord($id);
        
        $product->fill([
            'title' => trim($validated['title']),
            'sku' => trim($validated['sku']),
            'category_id' => $validated['category_id'],
            'sub_category_id' => $validated['sub_category_id'],
            'brand_id' => $validated['brand_id'],
            'old_price' => $validated['old_price'] ? number_format($validated['old_price'], 2, '.', '') : null,
            'price' => number_format($validated['price'], 2, '.', ''),
            'short_description' => trim($validated['short_description'] ?? ''),
            'description' => trim($validated['description']),
            'additional_info' => trim($validated['additional_info'] ?? ''),
            'ship_and_returns' => trim($validated['ship_and_returns'] ?? ''),
            'status' => $validated['status']
        ]);

        $product->save();

        ProductColoursModel::where('product_id', $id)->delete();
        if (!empty($request->colour_id)) {
            $colourData = array_map(function($colourId) use ($id) {
                return [
                    'product_id' => $id,
                    'colour_id' => $colourId,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }, $request->colour_id);
            ProductColoursModel::insert($colourData);
        }

        ProductSizesModel::where('product_id', $id)->delete();
        if (!empty($request->size)) {
            $sizeData = [];
            foreach ($request->size as $size) {
                if (!empty($size['name'])) {
                    $sizeData[] = [
                        'product_id' => $id,
                        'name' => $size['name'],
                        'price' => !empty($size['price']) ? number_format($size['price'], 2, '.', '') : 0,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
            if (!empty($sizeData)) {
                ProductSizesModel::insert($sizeData);
            }
        }

        if ($request->hasFile('image')) {
            
                foreach ($request->file('image') as $image) {
                    if ($image->isValid()) {
                        // Generate unique filename
                        $ext = $image->getClientOriginalExtension();
                        $randomStr = $product->id . '_' . time() . '_' . Str::random(10);
                        $filename = strtolower($randomStr) . '.' . $ext;
                        $path = 'backend/upload/products/';

                        // Ensure directory exists
                        $uploadPath = public_path($path);
                        if (!file_exists($uploadPath)) {
                            mkdir($uploadPath, 0755, true);
                        }

                        // Move the file
                        if ($image->move($uploadPath, $filename)) {
                            // Save image record to database
                            ProductImagesModel::create([
                                'product_id' => $id,
                                'image_name' => $filename,
                                'image_extension' => $ext,
                                'order_by' => ProductImagesModel::where('product_id', $id)->count() + 1
                            ]);
                        } else {
                            throw new \Exception("Failed to move uploaded file: $filename");
                        }
                    }
                }
            
        }

        return redirect()->back()->with('success', 'Product updated successfully');

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

    public function deleteImage(int $id)
    {
        $image = ProductImagesModel::getImageById($id);

        if (!empty($image->image_name)) {
            $path = public_path('backend/upload/products/' . $image->image_name);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $image->delete();

        return response()->json(['success' => true]);
    }

    public function product_image_sort(Request $request)
    {
        if ($request->has('sortedIDs') && is_array($request->sortedIDs)) {
            foreach ($request->sortedIDs as $key => $val) {
                $id = str_replace('image-', '', $val); // remove 'image-' prefix
                ProductImagesModel::where('id', $id)->update(['order_by' => $key]);
            }
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
