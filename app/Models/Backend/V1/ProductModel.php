<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\V1\ProductImagesModel;
use App\Models\Backend\V1\ProductSizesModel;
use App\Models\Backend\V1\ProductColoursModel;
use App\Models\Backend\V1\CategoryModel;
use App\Models\Backend\V1\SubCategoryModel;
use App\Models\Backend\V1\BrandsModel;
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

    static public function findBySlug($slug)
    {
        return self::where('slug', $slug)
            ->where('is_delete', 0)
            ->where('status', 1)
            ->first();

    }

    public function productColours()
    {
        return $this->hasMany(ProductColoursModel::class, 'product_id', 'id');
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSizesModel::class, 'product_id', 'id');
    }
    
    
    public static function getProducts($filters = [], $categoryId = '', $subCategoryId = '')
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

    
    if (!empty($filters['search'])) {
        $search = $filters['search'];
        $query->where(function ($q) use ($search) {
            $q->where('product.title', 'LIKE', "%$search%")
              ->orWhere('product.short_description', 'LIKE', "%$search%")
              ->orWhere('product.description', 'LIKE', "%$search%");
        });
    }


    if (!empty($filters['sortby'])) {
        switch ($filters['sortby']) {
            case 'popularity':
                $query->orderBy('product.total_views', 'desc');
                break;
            case 'rating':
                $query->orderBy('product.avg_rating', 'desc');
                break;
            case 'date':
                $query->orderBy('product.created_at', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('product.price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('product.price', 'desc');
                break;
            default:
                $query->orderBy('product.id', 'desc');
                break;
        }
    } else {
        $query->orderBy('product.id', 'desc');
    }

    
    $query->distinct('product.id');

    
    return $query->paginate(12);
}


    static public function getRelatedProduct($excludeId, $subCategoryId)
    {
        return self::select(
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
            ->where('product.id', '!=', $excludeId)
            ->where('sub_category_id', $subCategoryId)
            ->where('product.is_delete', 0)
            ->where('product.status', 1)
            ->groupBy('product.id')
            ->orderBy('product.id', 'desc')
            ->limit(10)
            ->get();
    }

    public function getImages()
    {
        return $this->hasMany(ProductImagesModel::class, 'product_id', 'id')->orderBy('order_by', 'asc');
    }

    public function getCategory()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }

    public function getSubCategory()
    {
        return $this->belongsTo(SubCategoryModel::class, 'sub_category_id', 'id');
    }


}
