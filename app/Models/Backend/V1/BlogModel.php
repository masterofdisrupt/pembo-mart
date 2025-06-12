<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BlogComment;
use Request;

class BlogModel extends Model
{
    use HasFactory;

    protected $table = 'blog';

    protected $fillable = [
        'title',
        'slug',
        'blog_category_id',
        'description',
        'image_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status'
    ];

    public static function getRecords($request)
    {
        $query = self::query()->orderBy('id', 'desc');

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

    public static function getActiveRecords()
    {
        return self::where('status', 1)->get();
    }

    public static function getActiveHomeRecords()
    {
        return self::where('status', 1)
                    ->where('is_delete', 0)
                    ->orderBy('id', 'desc')
                    ->take(3)
                    ->get();
    }

    public static function getBlog($blog_category_id = '')
    {
        $return = self::select('blog.*');

        if (Request::filled('search')) {
            $return = $return->where(function($query) {
                $query->where('title', 'like', '%' . Request::get('search') . '%')
                    ->orWhere('slug', 'like', '%' . Request::get('search') . '%');
            });
        }

        if (!empty($blog_category_id)) {
            $return = $return->where('blog_category_id', $blog_category_id);
        }

        $return = $return->where('is_delete', 0)
                        ->where('status', 1)
                        ->orderBy('id', 'desc')
                        ->paginate(10);

        return $return;
    }

    public static function getPopularBlogs()
    {
        return self::where('status', 1)
                    ->where('is_delete', 0)
                    ->orderBy('total_views', 'desc')
                    ->take(5)
                    ->get();
    }

    public static function getRelatedPosts($categoryId, $blogId)
    {
        return self::where('blog_category_id', $categoryId)
                    ->where('id', '!=', $blogId)
                    ->where('is_delete', 0)
                    ->where('status', 1)
                    ->orderBy('id', 'desc')
                    ->take(5)
                    ->get();
    }

    public static function getSingleRecord($id)
    {
        return self::find($id);
    }

    public static function getRecordBySlug($slug)
    {
        return self::where('slug', $slug)->where('status', 1)->first();
    }

    public function getCategory()
    {
        return $this->belongsTo(BlogCategoryModel::class, 'blog_category_id', 'id');
    }

    public function getComments()
    {
        return $this->hasMany(BlogComment::class, 'blog_id', 'id')
                ->select('blog_comments.*')
                ->join('users', 'users.id', '=', 'blog_comments.user_id')
                ->orderBy('blog_comments.id' , 'desc');
    }

    public function getCommentsCount()
    {
        return $this->getComments()->count();
    }

    /**
     * Get the URL of the blog image.
     *
     * @return string|null
     */
    public function getImage()
    {
         if(!empty($this->image_name) && file_exists(public_path('backend/upload/blogs/' . $this->image_name))) {
        
        return url('public/backend/upload/blogs/' . $this->image_name);
    }
    return null;
    }
}
