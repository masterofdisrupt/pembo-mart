<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class CityModel extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = ['country_id', 'state_id', 'city_name'];

    static public function getJoinedRecord($request)
    {
        $query = self::select('cities.*', 'countries.country_name', 'states.state_name')
            ->join('countries', 'countries.id', '=', 'cities.country_id')
            ->join('states', 'states.id', '=', 'cities.state_id')
            ->where('cities.is_delete',  0)
            ->orderBy('cities.id', 'desc');

        // Search Filters
        if ($request->filled('id')) {
            $query->where('cities.id', $request->id);
        }

        if ($request->filled('country_name')) {
            $query->where('countries.country_name', 'like', '%' . $request->country_name . '%');
        }

        if ($request->filled('state_name')) {
            $query->where('states.state_name', 'like', '%' . $request->state_name . '%');
        }

        if ($request->filled('city_name')) {
            $query->where('cities.city_name', 'like', '%' . $request->city_name . '%');
        }

        return $query->paginate(20);
    }

}
