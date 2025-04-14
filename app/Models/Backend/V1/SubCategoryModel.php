<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryModel extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'status',
        'created_by',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_at',
        'updated_at',

    ];

    /**
     * Get the records from the sub_categories table with related category and user names.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */

    static public function getRecords()
    {
        return self::select('sub_categories.*', 'users.name as created_by_name', 'categories.name as category_name')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('users', 'sub_categories.created_by', '=', 'users.id')
            ->where('sub_categories.is_delete', 0)
            ->orderBy('sub_categories.created_at', 'desc')
            ->paginate(20);
    }

    /**
     * Get the record by ID from the sub_categories table.
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

    static public function findBySlug($slug)
    {
        return self::select('sub_categories.*')
        ->where('sub_categories.slug', $slug)
        ->where('sub_categories.is_delete', 0)
        ->where('sub_categories.status', 1)
        
        ->first();
    }

    static public function getRecordSubCategory($category_id) 
    {
        return self::select('sub_categories.*', 'categories.name as category_name')
        ->join('users', 'sub_categories.created_by', '=', 'users.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->where('sub_categories.id', $id)
            ->where('sub_categories.is_delete', 0)
            ->orderBy('sub_categories.created_at', 'asc')
            ->get();
        
    }
}
