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
        'price',
        'product_code',
        'description',
        'created_by',
        'slug'
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
}
