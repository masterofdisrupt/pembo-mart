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
    static public function getSingle($id)
    {
        return self::where('id', $id)->first();
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
    static public function getCategorySlug($id)
    {
        return self::where('id', $id)->value('slug');
    }
    
}
