<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Backend\V1\ProductModel;
use App\Models\Backend\V1\ProductSizesModel;
use App\Models\Backend\V1\DiscountCodeModel;
use App\Models\Backend\V1\ShippingChargesModel;
use App\Models\Backend\V1\OrdersModel;
use App\Models\Backend\V1\OrdersDetailsModel;
use App\Models\Backend\V1\ColourModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Cart;


class OrderPlacementService
{
    public function placeOrder(Request $request)
{
    $user_id = Auth::check() ? Auth::id() : null;

    if (!$user_id && !empty($request->is_create)) {
        if (User::checkemail($request->email)) {
            return response()->json([
                'success' => false,
                'message' => 'Email already exists. Please use a different email.'
            ]);
        }

        $user = new User();
        $user->fill([
            'first_name' => trim($request->first_name),
            'last_name'  => trim($request->last_name),
            'email'      => trim($request->email),
            'phone'      => trim($request->phone),
            'password'   => Hash::make($request->password),
        ]);
        $user->save();

        $user_id = $user->id;
    }

    $validated = $request->validate([
        'first_name'      => 'required|string|max:255',
        'last_name'       => 'required|string|max:255',
        'email'           => 'required|email',
        'phone'           => 'required|string|max:20',
        'address_one'     => 'required|string',
        'address_two'     => 'nullable|string',
        'city'            => 'required|string',
        'state'           => 'required|string',
        'country'         => 'required|string',
        'postcode'        => 'required|string',
        'shipping'        => 'required|integer|exists:shipping_charges,id',
        'payment_method'  => 'required|in:wallet,cash',
        'discount_code'   => 'nullable|string|exists:discount_code,code',
    ]);

    $total = Cart::getSubTotal();
    $discount_amount = 0;
    $discount_code = $request->discount_code;

    if (!empty($discount_code)) {
        if ($request->payment_method !== 'wallet') {
            return response()->json([
                'success' => false,
                'message' => 'Discount codes can only be used with wallet payments.',
            ]);
        }

        $discount = DiscountCodeModel::CheckDiscountCode($discount_code);
        if ($discount) {
            $discount_amount = $discount->type === 0
                ? ($total * $discount->discount_price) / 100
                : $discount->discount_price;
            $total -= $discount_amount;
        }
    }

    $shipping = ShippingChargesModel::getSingleRecord($request->shipping);
    $shipping_amount = $shipping->price ?? 0;
    $total += $shipping_amount;

    $order = new OrdersModel();
    $order->user_id = $user_id;
    $order->fill([
        'first_name'      => trim($request->first_name),
        'last_name'       => trim($request->last_name),
        'company_name'    => trim($request->company_name),
        'email'           => trim($request->email),
        'phone'           => trim($request->phone),
        'address_one'     => trim($request->address_one),
        'address_two'     => trim($request->address_two),
        'city'            => trim($request->city),
        'state'           => trim($request->state),
        'country'         => trim($request->country),
        'postcode'        => trim($request->postcode),
        'notes'           => trim($request->notes),
        'shipping_id'     => $request->shipping,
        'payment_method'  => $request->payment_method,
        'discount_code'   => $discount_code,
        'discount_amount' => $discount_amount,
        'shipping_amount' => $shipping_amount,
        'total_amount'    => $total,
    ]);
    $order->save();

    foreach (Cart::getContent() as $cartItem) {
        $product = ProductModel::getSingleRecord($cartItem->id);
        $colour  = ColourModel::getSingleRecord($cartItem->attributes['colour_id'] ?? null);
        $size    = ProductSizesModel::getSingleRecord($cartItem->attributes['size_id'] ?? null);

        $orderDetails = new OrdersDetailsModel();
        $orderDetails->orders_id   = $order->id;
        $orderDetails->product_id  = $product->id;
        $orderDetails->quantity    = $cartItem->quantity;
        $orderDetails->price       = $cartItem->price;
        $orderDetails->colour_name = $colour->name ?? null;
        $orderDetails->size_name   = $size->name ?? null;
        $orderDetails->size_amount = $size->price ?? null;
        $orderDetails->total_price = $cartItem->price * $cartItem->quantity;
        $orderDetails->save();
    }

    return response()->json([
        'success' => true,
        'message' => 'Order placed successfully!',
        'redirect_url' => route('order.success', base64_encode(json_encode(['order_id' => $order->id]))),
    ]);
}
}
