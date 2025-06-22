<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $table = 'partners';

    public static function getSingleRecord($id)
    {
        return self::find($id);
    }

    public static function getRecord()
    {
        return self::where('is_delete', 0)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->paginate(20);
    }

    public function getPartnerImage()
    {
         if(!empty($this->image_name) && file_exists(public_path('backend/upload/partners/' . $this->image_name))) {
        
        return url('public/backend/upload/partners/' . $this->image_name);
    }
    return null;
    }

    static public function getActiveRecords()
    {
        return self::where('is_delete', 0)
            ->where('status', 1)
            ->orderBy('id', 'asc')
            ->get();
    }

}
