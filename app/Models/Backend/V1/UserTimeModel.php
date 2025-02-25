<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;


class UserTimeModel extends Model
{
    use HasFactory;

    protected $table = 'user_time';

    static public function getDetail($weekid)
    {
        return self::where('week_id', '=', $weekid)->where('user_id', '=', Auth::user()->id)->first();
    }
}
