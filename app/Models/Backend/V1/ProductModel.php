<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function getImages()
{
    return $this->hasMany(ProductImagesModel::class, 'product_id', 'id')->orderBy('order_by', 'asc');
}
}
