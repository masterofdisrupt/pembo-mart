<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Backend\V1\CategoryModel;
use App\Models\Backend\V1\SubCategoryModel;

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
        $data['getSubCategory'] = $getSubCategory;
        $data['getCategory'] = $getCategory;
        // Return the view with the category and subcategory data
        return view('products.list', $data);
    } else if (!empty($getCategory)) {
        $data['getCategory'] = $getCategory;
        // Return the view with only the category data
        return view('products.list', $data);
    } else {
        // If the category does not exist, return a 404 error
        abort(404);
    }
}

}

