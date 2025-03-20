<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AddressModel extends Model
{
    use HasFactory;

    protected $table = 'address';

    protected $fillable = [
        'country_id',
        'state_id',
        'city_id',
        'address',
        'zip_code',
    ];

    /**
     * Get all records with filters and pagination.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getRecordAll(Request $request)
    {
        $query = self::select('address.*', 'countries.country_name', 'states.state_name', 'cities.city_name')
            ->join('countries', 'countries.id', '=', 'address.country_id')
            ->join('states', 'states.id', '=', 'address.state_id')
            ->join('cities', 'cities.id', '=', 'address.city_id')
            ->where('countries.is_delete', 0) 
            ->where('states.is_delete', 0) 
            ->where('cities.is_delete', 0)
            ->where('address.is_delete', 0); 

        if ($request->filled('id')) {
            $query->where('address.id', $request->id);
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

        if ($request->filled('address')) {
            $query->where('address.address', 'like', '%' . $request->address . '%');
        }

        return $query->orderBy('address.id', 'desc')->paginate(50);
    }
}