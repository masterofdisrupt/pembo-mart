<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\V1\ProductImagesModel;
use App\Models\Backend\V1\ProductSizesModel;
use App\Models\Backend\V1\ProductColoursModel;

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



static public function getProducts($categoryId = '', $subCategoryId = '')
{
    return self::select('product.*', 'users.name as created_by_name', 'categories.name as category_name', 
    'categories.slug as category_slug', 'sub_categories.name as sub_category_name', 'sub_categories.slug as sub_category_slug')
        ->join('users', 'product.created_by', '=', 'users.id')
        ->join('categories', 'product.category_id', '=', 'categories.id')
        ->join('sub_categories', 'product.sub_category_id', '=', 'sub_categories.id')
        ->where('product.is_delete', 0)
        ->where('product.status', 1)
        ->when($categoryId, function ($query) use ($categoryId) {
            return $query->where('product.category_id', $categoryId);
        })
        ->when($subCategoryId, function ($query) use ($subCategoryId) {
            return $query->where('product.sub_category_id', $subCategoryId);
        })
        ->orderBy('product.id', 'desc')
        ->paginate(1);
}

    public function getImages()
{
    return $this->hasMany(ProductImagesModel::class, 'product_id', 'id')->orderBy('order_by', 'asc');
}


}
