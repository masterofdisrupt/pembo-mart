<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductReviews;
use Illuminate\Support\Facades\Auth;


class OrdersDetailsModel extends Model
{
    use HasFactory;

    protected $table = 'orders_details';

    protected $fillable = ['orders_id', 'colour_id'];

    public function getProduct()
    {
        return $this->belongsTo(ProductModel::class, 'product_id')
            ->select('id', 'title', 'price', 'slug');
    }

    public static function getReview($product_id, $order_id)
    {
        return ProductReviews::getReview($product_id, $order_id, Auth::id());
    }
    
}
