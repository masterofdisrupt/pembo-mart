<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImagesModel extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    protected $fillable = [
        'product_id',
        'image_name',
        'image_extension',
        'order_by',
    ];

    protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime'
];

static public function getImageById($id)
{
    return self::find($id);
}

public function getProductImages()
{
    if(!empty($this->image_name) && file_exists(public_path('backend/upload/products/' . $this->image_name))) {
        
        return url('public/backend/upload/products/' . $this->image_name);
    }
    return null;
}

/**
     * Delete the image file when model is deleted
     */
    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($image) {
            $path = public_path('backend/upload/products/' . $image->image_name);
            if (file_exists($path)) {
                unlink($path);
            }
        });
    }


}
