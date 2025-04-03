<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;


class WeekTimeModel extends Model
{
    use HasFactory;

    protected $table = 'week_time';

    protected $fillable = [
        'name',   
    ];

    static public function getRecordAll()
    {
        $return = self::select('week_time.*');

        if (!empty(Request::get('id'))) {
            $return = $return->where('week_time.id', '=', Request::get('id'));
        }

        if (!empty(Request::get('name'))) {
            $return = $return->where('week_time.name', 'like', '%' . Request::get('name') . '%');
        }

        $return = $return->get();

        return $return;
    }
}
