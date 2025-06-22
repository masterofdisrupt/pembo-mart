<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWishlists extends Model
{
    use HasFactory;

    protected $table = 'product_wishlists';

    protected $fillable = [
        'user_id',
        'product_id',
        'created_at',
        'updated_at'
    ];

    public static function getSingleRecord($id)
    {
        return self::find($id);
    }

     public static function checkExisting($userId, $productId)
    {
        return self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->count();
    }

    public static function deleteRecord($userId, $productId)
    {
        return self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }
}
