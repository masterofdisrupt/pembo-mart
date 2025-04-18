<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSizesModel extends Model
{
    use HasFactory;

    protected $table = 'product_sizes';

    protected $fillable = [
        'product_id',
        'name',
        'price',
    ];

    static public function getRecords($id)
    {
        return self::where('product_id', $id)->where('is_delete', 0)->get();
    }

    static public function getSingleRecord($id)
    {
        return self::where('id', $id)->first();
    }
}
