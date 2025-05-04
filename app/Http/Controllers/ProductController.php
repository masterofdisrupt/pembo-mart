<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Backend\V1\CategoryModel;
use App\Models\Backend\V1\SubCategoryModel;
use App\Models\Backend\V1\ProductModel;
use App\Models\Backend\V1\ColourModel;
use App\Models\Backend\V1\BrandsModel;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $metaData = [
            'meta_title' => 'Search Results for: ' . $search,
            'meta_description' => 'Search results for: ' . $search,
            'meta_keywords' => $search,
        ];

        $getProduct = ProductModel::getProducts(['search' => $search]);
        $getColour = ColourModel::getColourStatus();
        $getBrand = BrandsModel::getBrandStatus();

        $priceMin = ProductModel::min('price') ?? 0;
        $priceMax = ProductModel::max('price') ?? 1000000;

        $selectedPriceMin = $request->input('price_min', $priceMin);
        $selectedPriceMax = $request->input('price_max', $priceMax);

        $page = null;
    if ($getProduct->hasMorePages()) {
        $nextPageUrl = $getProduct->nextPageUrl();
        if ($nextPageUrl) {
            parse_str(parse_url($nextPageUrl, PHP_URL_QUERY), $queryParams);
            $page = $queryParams['page'] ?? null;
        }
    }

        return view('products.list', [
            'getProduct' => $getProduct,
            'getColour' => $getColour,
            'getBrand' => $getBrand,
            'priceMin' => $priceMin,
            'priceMax' => $priceMax,
            'selectedPriceMin' => $selectedPriceMin,
            'selectedPriceMax' => $selectedPriceMax,
            'meta_title' => $metaData['meta_title'],
            'meta_description' => $metaData['meta_description'],
            'meta_keywords' => $metaData['meta_keywords'],
            'page' => $page,
        ]);

    }


   public function getCategory(Request $request, $slug, $subSlug = null)
{
    $getCategory = CategoryModel::findBySlug($slug);
    if (!$getCategory) {
        abort(404, 'Category not found');
    }

    $getSubCategory = $subSlug ? SubCategoryModel::findBySlug($subSlug) : null;
    if ($subSlug && !$getSubCategory) {
        abort(404, 'Subcategory not found');
    }

    $getColour = ColourModel::getColourStatus();
    $getBrand = BrandsModel::getBrandStatus();

    $priceMin = ProductModel::min('price') ?? 0;
    $priceMax = ProductModel::max('price') ?? 1000000;

    $selectedPriceMin = $request->input('price_min', $priceMin);
    $selectedPriceMax = $request->input('price_max', $priceMax);

    $metaData = [
        'meta_title' => $getSubCategory->meta_title ?? $getCategory->meta_title,
        'meta_description' => $getSubCategory->meta_description ?? $getCategory->meta_description,
        'meta_keywords' => $getSubCategory->meta_keywords ?? $getCategory->meta_keywords,
    ];

    $getProduct = ProductModel::getProducts(
        $request->all(), 
        $getCategory->id, 
        $getSubCategory->id ?? ''
    );

    $page = null;
    if ($getProduct->hasMorePages()) {
        $nextPageUrl = $getProduct->nextPageUrl();
        if ($nextPageUrl) {
            parse_str(parse_url($nextPageUrl, PHP_URL_QUERY), $queryParams);
            $page = $queryParams['page'] ?? null;
        }
    }

    $subCategoryFilter = SubCategoryModel::getRecordSubCategory($getCategory->id);

    return view('products.list', [
    'getColour' => $getColour,
    'getBrand' => $getBrand,
    'priceMin' => $priceMin,
    'priceMax' => $priceMax,
    'selectedPriceMin' => $selectedPriceMin,
    'selectedPriceMax' => $selectedPriceMax,
    'getCategory' => $getCategory,
    'getSubCategory' => $getSubCategory,
    'getProduct' => $getProduct,
    'subCategoryFilter' => $subCategoryFilter,
    'meta_title' => $metaData['meta_title'],
    'meta_description' => $metaData['meta_description'],
    'meta_keywords' => $metaData['meta_keywords'],
    'page' => $page,
]);
}

public function productDetails($slug)
{
    $product = ProductModel::findBySlug($slug);
    
    if (!$product) {
        abort(404, 'Product not found');
    }

    $getRelatedProduct = ProductModel::getRelatedProduct($product->id, $product->sub_category_id);

    $metaData = [
        'meta_title' => $product->title,
        'meta_description' => $product->short_description,
        
    ];


    return view('products.detail', [
    'product' => $product,
    'meta_title' => $product->title,
    'meta_description' => $product->short_description,
    'getRelatedProduct' => $getRelatedProduct,
]);
}




public function products_filter(Request $request)
{
    try {
        $filters = $request->all(); 
        $categoryId = $request->get('category_id');
        $subCategoryId = $request->get('sub_category_id');
        $page = $request->get('page', 1);

        $getProduct = ProductModel::getProducts($filters, $categoryId, $subCategoryId);

        $nextPage = null;
        if ($getProduct->hasMorePages()) {
            $nextPageUrl = $getProduct->nextPageUrl();
            if ($nextPageUrl) {
                parse_str(parse_url($nextPageUrl, PHP_URL_QUERY), $queryParams);
                $nextPage = $queryParams['page'] ?? null;
            }
        }

        $html = view('products._list', compact('getProduct'))->render();

        return response()->json([
            'status' => true,
            'html' => $html,
            'pagination' => [
                'total' => $getProduct->total(),
                'currentPage' => $getProduct->currentPage(),
                'hasMorePages' => $getProduct->hasMorePages(),
                'nextPage' => $nextPage,
            ],
            'message' => 'Products filtered successfully'
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Product filter error: ' . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Error filtering products. Please try again.'
        ], 500);
    }
}

public function loadMore(Request $request)
{
    try {
        $filters = $request->get('filters', []);
        $page = $request->get('page', 1);

        $getProduct = ProductModel::getProducts($filters, '', '', $page);

        $view = view('products._list', compact('getProduct'))->render();

        return response()->json([
            'status' => true,
            'html' => $view,
            'hasMorePages' => $getProduct->hasMorePages(),
            'nextPage' => $getProduct->currentPage() + 1
        ]);
    } catch (\Exception $e) {
        \Log::error('Load More Error: ' . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Error loading more products'
        ], 500);
    }
}

}

