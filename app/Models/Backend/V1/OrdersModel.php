<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersModel extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
    'user_id',
    'order_number',
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

    public static function getUserOrders($user_id)
{
    return self::with(['getShipping', 'product', 'ordersDetails.getProduct'])
        ->select('orders.*')
        ->where('orders.user_id', $user_id)
        ->where('orders.is_payment', 1)
        ->where('orders.is_delete', 0)
        ->orderByDesc('orders.id')
        ->paginate(10);
}

public static function getUserOrderById($user_id, $id)  
{
    return self::with(['getShipping', 'product', 'ordersDetails.getProduct'])
        ->select('orders.*')
        ->where('orders.user_id', $user_id)
        ->where('orders.id', $id)
        ->where('orders.is_payment', 1)
        ->where('orders.is_delete', 0)
        ->first();
}


  public static function getRecord(Request $request)
{
    return self::with(['getShipping', 'product', 'ordersDetails.getProduct']) 
        ->select('orders.*')
        ->where('orders.is_payment', 1)
        ->where('orders.is_delete', 0)
        ->when($request->id, fn($query, $id) => $query->where('orders.id', $id))
        ->when($request->first_name, fn($query, $name) => $query->where('orders.first_name', 'LIKE', "%{$name}%"))
        ->when($request->last_name, fn($query, $name) => $query->where('orders.last_name', 'LIKE', "%{$name}%"))
        ->when($request->email, fn($query, $email) => $query->where('orders.email', 'LIKE', "%{$email}%"))
        ->when($request->phone, fn($query, $phone) => $query->where('orders.phone', 'LIKE', "%{$phone}%"))
        ->when($request->address_one, fn($query, $address) => $query->where('orders.address_one', 'LIKE', "%{$address}%"))
        ->when($request->city, fn($query, $city) => $query->where('orders.city', 'LIKE', "%{$city}%"))
        ->when($request->state, fn($query, $state) => $query->where('orders.state', 'LIKE', "%{$state}%"))
        ->when($request->country, fn($query, $country) => $query->where('orders.country', 'LIKE', "%{$country}%"))
        ->when($request->postcode, fn($query, $postcode) => $query->where('orders.postcode', 'LIKE', "%{$postcode}%"))
        ->when($request->from_date, function ($query, $fromDate) {
            $query->where('orders.created_at', '>=', Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay());
        })
        ->when($request->to_date, function ($query, $toDate) {
            $query->where('orders.created_at', '<=', Carbon::createFromFormat('Y-m-d', $toDate)->endOfDay());
        })

        ->orderByDesc('orders.id')
        ->paginate(40);
}

    public static function getSingleRecord($id)
    {
        return self::with('ordersDetails.getProduct', 'user')->find($id);
    }

    public static function generateOrderNumber()
{
    $latestOrder = self::orderBy('id', 'desc')->first();
    $lastOrderNumber = $latestOrder ? (int) substr($latestOrder->order_number, 3) : 0;
    $newOrderNumber = str_pad($lastOrderNumber + 1, 6, '0', STR_PAD_LEFT);
    return 'ORD' . $newOrderNumber;
}

// User part
public static function userTotalOrders($user_id)
{
    return self::where('user_id', $user_id)
        ->where('is_payment', 1)
        ->where('is_delete', 0)
        ->count();
}

public static function userTodayOrders($user_id)
{
    return self::where('user_id', $user_id)
        ->where('is_payment', 1)
        ->where('is_delete', 0)
        ->whereDate('created_at', Carbon::today())
        ->count();
}

public static function userTotalAmount($user_id)
{
    return self::where('user_id', $user_id)
        ->where('is_payment', 1)
        ->where('is_delete', 0)
        ->sum('total_amount');
}

public static function userTodayAmount($user_id)
{
    return self::where('user_id', $user_id)
        ->where('is_payment', 1)
        ->where('is_delete', 0)
        ->whereDate('created_at', Carbon::today())
        ->sum('total_amount');
}

public static function userPendingOrders($user_id, $status)
{
    return self::where('user_id', $user_id)
        ->where('is_payment', 1)
        ->where('is_delete', 0)
        ->where('status', 0)
        ->count();
}

public static function userProcessingOrders($user_id, $status)
{
    return self::where('user_id', $user_id)
        ->where('is_payment', 1)
        ->where('is_delete', 0)
        ->where('status', 1)
        ->count();
}

public static function userCompletedOrders($user_id, $status)
{
    return self::where('user_id', $user_id)
        ->where('is_payment', 1)
        ->where('is_delete', 0)
        ->where('status', 3)
        ->count();
}

public static function userCanceledOrders($user_id, $status)
{
    return self::where('user_id', $user_id)
        ->where('is_payment', 1)
        ->where('is_delete', 0)
        ->where('status', 4)
        ->count();
}
   

// End user part

    public function getColour()
    {
        return $this->hasMany(OrdersDetailsModel::class, 'orders_id')
            ->select('orders_details.*', 'colour.name')
            ->join('colour', 'colour.id', '=', 'orders_details.colour_id');
    }

    public function getShipping()
{
    return $this->belongsTo(ShippingChargesModel::class, 'shipping_id', 'id');
}


public function product()
{
    return $this->belongsTo(ProductModel::class, 'product_id', 'id');
}

public function ordersDetails()
{
    return $this->hasMany(OrdersDetailsModel::class, 'orders_id', 'id');
} 

public function user()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
}



}