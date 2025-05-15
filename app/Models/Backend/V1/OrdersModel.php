<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class OrdersModel extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
         'user_id',
    'first_name',
    'last_name',
    'company_name',
    'email',
    'phone',
    'address_one',
    'address_two',
    'city',
    'state',
    'country',
    'postcode',
    'notes',
    'shipping_id',
    'payment_method',
    'discount_code',
    'discount_amount',
    'shipping_amount',
    'total_amount',
    ];


    static public function getRecord($request)
{
    return self::select('orders.*', 'product.title')
        ->join('product', 'product.id', '=', 'orders.product_id')
        ->when($request->id, fn($query, $id) => $query->where('orders.id', $id))
        ->when($request->title, fn($query, $title) => $query->where('product.title', 'like', "%$title%"))
        ->when($request->created_at, fn($query, $date) => $query->whereDate('orders.created_at', $date))
        ->when($request->updated_at, fn($query, $date) => $query->whereDate('orders.updated_at', $date))
        ->orderBy('orders.id', 'desc')
        ->paginate(40);
}

    static public function getSingleRecord($id)
    {
        return self::where('id', $id)->first();
    }

    public function getColour()
    {
        return $this->hasMany(OrdersDetailsModel::class, 'orders_id')
            ->select('orders_details.*', 'colour.name')
            ->join('colour', 'colour.id', '=', 'orders_details.colour_id');
    }


}
