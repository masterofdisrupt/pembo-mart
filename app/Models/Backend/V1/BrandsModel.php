<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandsModel extends Model
{
    use HasFactory;

    protected $table = 'brands';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'created_at',
        'updated_at'
    ];

    static public function getBrandById($id)
    {
        return self::where('id', $id)->first();
    }

    static public function getBrandBySlug($slug)
    {
        return self::where('slug', $slug)->first();
    }

    static public function getRecords() 
    {
        return self::select('brands.*', 'users.name as created_by_name')
            ->join('users', 'brands.created_by', '=', 'users.id')
            ->where('brands.is_delete', 0)
            ->orderBy('brands.id', 'desc')
            ->get();
    }

    static public function getBrandStatus()
    {
        return self::select('brands.*')
            ->join('users', 'brands.created_by', '=', 'users.id')
            ->where('brands.is_delete', 0)
            ->where('brands.status', 1)
            ->orderBy('brands.name', 'asc')
            ->get();
    }

}
