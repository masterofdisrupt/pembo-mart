<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Backend\V1\CategoryModel;
use App\Models\Backend\V1\SubCategoryModel;
use App\Models\Backend\V1\ProductModel;

class ProductController extends Controller
{
   public function getCategory($slug, $subSlug = null)
{
    // Fetch the category from the database using the slug
    $getCategory = CategoryModel::findBySlug($slug);

    // Fetch the subcategory if subSlug is provided
    $getSubCategory = null;
    if ($subSlug) {
        $getSubCategory = SubCategoryModel::findBySlug($subSlug);
    }

    if (!empty($getCategory) && !empty($getSubCategory)) {

        $data['meta_title'] = $getSubCategory->meta_title;
        $data['meta_description'] = $getSubCategory->meta_description;
        $data['meta_keywords'] = $getSubCategory->meta_keywords;
        $data['getSubCategory'] = $getSubCategory;
        $data['getCategory'] = $getCategory;

        $data['getProduct'] = ProductModel::getProducts(
            $getCategory->id,
            $getSubCategory->id
        );

        // Return the view with the category and subcategory data
        return view('products.list', $data);
    } else if (!empty($getCategory)) {
        $data['meta_title'] = $getCategory->meta_title;
        $data['meta_description'] = $getCategory->meta_description;
        $data['meta_keywords'] = $getCategory->meta_keywords;
        $data['getCategory'] = $getCategory;

        $data['getProduct'] = ProductModel::getProducts($getCategory->id);
        // Return the view with only the category data
        return view('products.list', $data);
    } else {
        // If the category does not exist, return a 404 error
        abort(404);
    }
}

}

