<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class OrdersModel extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = ['product_id', 'qtys'];


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


    public function getColour()
    {
        return $this->hasMany(OrdersDetailsModel::class, 'orders_id')
            ->select('orders_details.*', 'colour.name')
            ->join('colour', 'colour.id', '=', 'orders_details.colour_id');
    }

}
