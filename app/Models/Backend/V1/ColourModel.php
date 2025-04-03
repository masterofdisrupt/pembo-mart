<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\V1\OrdersDetailsModel;
use Request;


class ColourModel extends Model
{
    use HasFactory;

    protected $table = 'colour';

    static public function getRecordAll($request)
    {
        $return = self::select('colour.*')->orderBy('colour.id', 'desc');

        // Search Start
        if (!empty($request->id)) {
            $return = $return->where('colour.id', '=', $request->id);
        }

        if (!empty($request->name)) {
            $return = $return->where('colour.name', 'like', '%' . $request->name . '%');
        }

        if (!empty($request->created_at)) {
            $return = $return->where('colour.created_at', 'like', '%' . $request->created_at . '%');
        }

        $return = $return->get();
        return $return;
    }

    /**
     * Get the orders details associated with this colour
     */
    public function ordersDetails()
    {
        return $this->hasMany(ordersDetailsModel::class, 'colour_id', 'id');
    }

}

