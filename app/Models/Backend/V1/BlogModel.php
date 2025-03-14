<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogModel extends Model
{
    use HasFactory;

    protected $table = 'blog';

    static public function getAllRecord($request)
    {
        $query = self::query()->orderBy('id', 'desc');

        // Apply filters dynamically
        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('slug')) {
            $query->where('slug', 'like', '%' . $request->slug . '%');
        }

        return $query->paginate(30);
    }
}
