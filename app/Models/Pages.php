<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    protected $table = 'pages';

    public static function getSlug($slug)
    {
        return self::where('slug', $slug)->first();
    }

    public static function getRecord(){
        return self::select('pages.*')->get();
    }

    public function getPageImages()
{
    if(!empty($this->image_name) && file_exists(public_path('backend/upload/pages/' . $this->image_name))) {
        
        return url('public/backend/upload/pages/' . $this->image_name);
    }
    return null;
}
}
