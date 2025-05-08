<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ShippingChargesModel extends Model
{
    use HasFactory;

    protected $table = 'shipping_charges';

    protected $fillable = [
        'name',
        'price'
    ];

    static public function getAllRecords($request)
    {
        $query = self::select('*')
            ->where('is_delete', 0);

        // Apply filters
        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('price')) {
            $query->where('price', 'LIKE', '%' . $request->price . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        if ($request->filled('updated_at')) {
            $query->whereDate('updated_at', $request->updated_at);
        }

        return $query->orderBy('id', 'desc')->paginate(40);
    }
    
    /**
     * Get a single record by ID
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    

    static public function getSingleRecord($id)
    {
        return self::where('id', $id)
            ->where('is_delete', 0)
            ->where('status', 1)
            ->first();
    }

    /**
     * Get all active records
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    static public function getActiveRecords()
    {
        return self::where('is_delete', 0)
            ->where('status', 1)
            ->orderBy('id', 'asc')
            ->get();
    }

}
