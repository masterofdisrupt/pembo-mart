<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_by'
    ];

    /**
     * Get the records from the categories table with user name.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    
    static public function getRecords()
    {
        return self::select('categories.*', 'users.name as created_by_name')
            ->join('users', 'categories.created_by', '=', 'users.id')
            ->where('categories.is_delete', 0)
            ->orderBy('categories.created_at', 'desc')
            ->get();
    }

    /**
     * Get a single record from the categories table by ID.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    static public function getRecordById($id)
    {
        return self::where('id', $id)
        ->where('is_delete', 0)
        ->first();
    }
    /**
     * Get the name of the category by ID.
     *
     * @param int $id
     * @return string|null
     */
    static public function getCategoryName($id)
    {
        return self::where('id', $id)->value('name');
    }
    /**
     * Get the slug of the category by ID.
     *
     * @param int $id
     * @return string|null
     */
    static public function findBySlug($slug)
    {
        return self::select('categories.*')
        ->where('categories.slug', $slug)
        ->where('categories.is_delete', 0)
        ->where('categories.status', 1)
        
        ->first();
    }

    /**
     * Get the status of the category by ID.
     *
     * @param int $id
     * @return string|null
     */
    static public function getCategoryStatus()
    {
        return self::select('categories.*')
        ->join('users', 'categories.created_by', '=', 'users.id')
        ->where('categories.is_delete', 0)
        ->where('categories.status', 1)
        ->orderBy('categories.name', 'asc')
        ->get();
    }

    public static function getCategoryStatusHome()
    {
        return self::select('categories.*')
        ->join('users', 'categories.created_by', '=', 'users.id')
        ->where('categories.is_delete', 0)
        ->where('categories.status', 1)
        ->where('categories.is_home', 1)
        ->orderBy('categories.id', 'asc')
        ->get();
    }

    /**
     * Get the status of the category menu.
     *
     * @param int $id
     * @return string|null
     */
    static public function getCategoryStatusMenu()
    {
        return self::select('categories.*')
        ->join('users', 'categories.created_by', '=', 'users.id')
        ->where('categories.is_delete', 0)
        ->where('categories.status', 1)
        ->get();
    }

    public static function getCategoryHeaderMenu()
    {
        return self::select('categories.*')
        ->join('users', 'categories.created_by', '=', 'users.id')
        ->where('categories.is_delete', 0)
        ->where('categories.status', 1)
        ->where('categories.is_menu', 1)
        ->orderBy('categories.name', 'asc')
        ->get();
    }

    public function getSubCategories()
    {
        return $this->hasMany(SubCategoryModel::class, 'category_id', 'id')
        ->where('status', 1)
            ->where('is_delete', 0);
    }

    public function getCategoryImage()
    {
         if(!empty($this->image_name) && file_exists(public_path('backend/upload/category/' . $this->image_name))) {
        
        return url('public/backend/upload/category/' . $this->image_name);
    }
    return null;
    }
    
}
