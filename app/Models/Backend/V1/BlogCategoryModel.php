<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategoryModel extends Model
{
    use HasFactory;

    protected $table = 'blog_category';

    protected $fillable = [
        'name',
        'title',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
        'status',
        'created_by',
        'updated_by',
        'is_delete',
    ];
    public static function getActiveRecords()
    {
        return self::where('is_delete', 0)
                ->where('status', 1)
                ->orderBy('name', 'asc')
                ->get();
    }

    public static function getRecordById($id)
    {
        return self::find($id);
    }

    public static function getRecordBySlug($slug)
    {
        return self::where('slug', $slug)
            ->where('is_delete', 0)
            ->first();
    }
    

    public static function getCategoryStatusHome()
    {
        return self::where('status', 1)->get();
    }

    public static function getRecords()
    {
        return self::where('is_delete', 0)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getBlogcount()
    {
        return $this->hasMany(BlogModel::class, 'blog_category_id', 'id')
            ->where('is_delete', 0)
            ->where('status', 1)
            ->count();
    }
}
