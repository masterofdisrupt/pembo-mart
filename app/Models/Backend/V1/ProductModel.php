<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\V1\ProductImagesModel;
use App\Models\Backend\V1\ProductSizesModel;
use App\Models\Backend\V1\ProductColoursModel;
use Request;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
    'title',
    'sku',
    'category_id',
    'sub_category_id',
    'brand_id',
    'old_price',
    'price',
    'short_description',
    'description',
    'additional_info',
    'ship_and_returns',
    'status',
    'images'
];

    static public function getRecords()
    {
        return self::select('product.*', 'users.name as created_by_name')
            ->join('users', 'product.created_by', '=', 'users.id')
            ->where('product.is_delete', 0)
            ->orderBy('product.id', 'desc')
            ->paginate(40);
    }

    static public function getSingleRecord($id)
    {
        return self::where('id', $id)->first();
    }

    static public function checkSlug($slug)
    {
        return self::where('slug', $slug)->count();
    }

    public function getColours()
    {
        return $this->hasMany(ProductColoursModel::class, 'product_id', 'id');
    }

    public function getSizes()
    {
        return $this->hasMany(ProductSizesModel::class, 'product_id', 'id');
    }



static public function getProducts($filters = [], $categoryId = '', $subCategoryId = '', $page = 1)
{
    $query = self::select(
            'product.*', 
            'users.name as created_by_name', 
            'categories.name as category_name',
            'categories.slug as category_slug', 
            'sub_categories.name as sub_category_name', 
            'sub_categories.slug as sub_category_slug'
        )
        ->join('users', 'product.created_by', '=', 'users.id')
        ->join('categories', 'product.category_id', '=', 'categories.id')
        ->leftJoin('sub_categories', 'product.sub_category_id', '=', 'sub_categories.id')
        ->where('product.is_delete', 0)
        ->where('product.status', 1);

    if ($categoryId) {
        $query->where('product.category_id', $categoryId);
    }

    if ($subCategoryId) {
        $query->where('product.sub_category_id', $subCategoryId);
    }

    if (!empty($filters['sub_category_id'])) {
        $sub_category_ids = explode(',', rtrim($filters['sub_category_id'], ','));
        $query->whereIn('product.sub_category_id', $sub_category_ids);
    } else {
        if (!empty($filters['old_category_id'])) {
            $query->where('product.category_id', $filters['old_category_id']);
        }

        if (!empty($filters['old_sub_category_id'])) {
            $query->where('product.sub_category_id', $filters['old_sub_category_id']);
        }
    }

    if (!empty($filters['colour_id'])) {
        $colour_ids = explode(',', rtrim($filters['colour_id'], ','));
        $query->join('product_colours', 'product.id', '=', 'product_colours.product_id')
              ->whereIn('product_colours.colour_id', $colour_ids);
    }

    if (!empty($filters['brand_id'])) {
        $brand_ids = explode(',', rtrim($filters['brand_id'], ','));
        $query->whereIn('product.brand_id', $brand_ids);
    }

    if (!empty($filters['price_min']) && !empty($filters['price_max'])) {
        $price_min = (float) filter_var(str_replace('₦', '', $filters['price_min']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $price_max = (float) filter_var(str_replace('₦', '', $filters['price_max']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if (is_numeric($price_min) && is_numeric($price_max)) {
            $query->whereBetween('product.price', [$price_min, $price_max]);
        }
    }

    if (!empty($filters['sortby'])) {
        if ($filters['sortby'] == 'popularity') {
            $query->orderBy('product.total_views', 'desc');
        } elseif ($filters['sortby'] == 'rating') {
            $query->orderBy('product.avg_rating', 'desc');
        } elseif ($filters['sortby'] == 'date') {
            $query->orderBy('product.created_at', 'desc');
        }
    } else {
        $query->orderBy('product.id', 'desc');
    }

    return $query->groupBy(
        'product.id',
        'users.name',
        'categories.name',
        'categories.slug',
        'sub_categories.name',
        'sub_categories.slug'
    )->paginate(2, ['*'], 'page', $page);
}




    public function getImages()
{
    return $this->hasMany(ProductImagesModel::class, 'product_id', 'id')->orderBy('order_by', 'asc');
}


}
