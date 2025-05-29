<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReviews extends Model
{
    use HasFactory;

    protected $table = 'product_reviews';

    protected $fillable = [
        'product_id',
        'order_id',
        'user_id',
        'rating',
        'review',
        'status',
    ];

    public static function getReview($productId, $orderId, $userId)
    {
        return self::where('product_id', $productId)
            ->where('order_id', $orderId)
            ->where('user_id', $userId)
            ->first();
    }

    public static function getProductReviews($productId)
    {
        return self::select('product_reviews.*', 'users.name as user_name')
            ->join('users', 'product_reviews.user_id', '=', 'users.id')
            ->where('product_reviews.product_id', $productId)
            ->orderBy('product_reviews.id', 'desc')
            ->paginate(20);
            
    }

    public static function getAvgRating($productId)
    {
        $avgRating = self::where('product_id', $productId)
        ->avg('rating');
        return $avgRating ? round($avgRating, 1) : 0;
    }

    public function getReviewsPercentage()
    {
        $Rating = $this->rating;
        if ($Rating == 1) {
            return 20;
        } elseif ($Rating == 2) {
            return 40;
        } elseif ($Rating == 3) {
            return 60;
        } elseif ($Rating == 4) {
            return 80;
        } elseif ($Rating == 5) {
            return 100;
        } else {
            return 0;
        }
    }
}
