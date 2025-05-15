<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Routing\Controller;
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

class PaymentController extends Controller
{
        public function applyDiscount(Request $request)
{
    $getDiscountCode = DiscountCodeModel::CheckDiscountCode($request->discount_code);

    if ($getDiscountCode) {
        $total = Cart::getSubTotal();

        if ($getDiscountCode->type == 0) { // 0 = Percentage
            $discount = ($total * $getDiscountCode->discount_price) / 100;
        } else { // 1 = Fixed amount
            $discount = $getDiscountCode->discount_price;
        }

        $payable_total = max(0, $total - $discount); // Prevent negative total
        $payable_total = number_format($payable_total, 2, '.', '');

        return response()->json([
            'success' => true,
            'message' => 'Discount code applied successfully.',
            'discount' => number_format($discount, 2, '.', ''),
            'payable_total' => $payable_total,
            'code' => $getDiscountCode->code,
             'status_badge' => $getDiscountCode->getStatusBadge()
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired discount code.',
            'discount' => '0.00',
            'payable_total' => Cart::getSubTotal(),
        ], 404);
    }
}

        


   public function checkout(Request $request)
{
    $cartItems = Cart::getContent()->map(function ($cartItem) {
    $product = ProductModel::getSingleRecord($cartItem->id);

    $colourId = $cartItem->attributes->get('colour_id');
    $sizeId = $cartItem->attributes->get('size_id');

    $colour = $colourId ? ColourModel::getSingleRecord($colourId) : null;
    $size = $sizeId ? ProductSizesModel::getSingleRecord($sizeId) : null;

    $cartItem->product = $product;
    $cartItem->colour = $colour;
    $cartItem->size = $size;


    return $cartItem;

});


    $metaData = [
        'meta_title' => 'Checkout',
        'meta_description' => '',
        'meta_keywords' => '',
    ];
    $shippingCharges = ShippingChargesModel::getActiveRecords();

    return view('payments.checkout', [
        'meta_title' => $metaData['meta_title'],
        'shippingCharges' => $shippingCharges,
        'cartItems' => $cartItems,
    ]);
}


    public function cart(Request $request)
    {
        $metaData = [
            'meta_title' => 'Cart',
            'meta_description' => '',
            'meta_keywords' => '',
        ];

        return view('payments.cart', [
            'meta_title' => $metaData['meta_title']
        ]);
    }

    public function addToCart(Request $request)
    {
        $getProduct = ProductModel::getSingleRecord($request->product_id);
        $total = $getProduct->price;

        if (!empty($request->size_id)) {
            $size_id = $request->size_id;
            $getSize = ProductSizesModel::getSingleRecord($size_id);
            $size_price = !empty($getSize->price) ? $getSize->price : 0;
            $total += $size_price;
        } else {
            $size_id = 0;
        }

        $colour_id = !empty($request->color_id) ? $request->color_id : 0;

        Cart::add([
            'id' => $getProduct->id,
            'name' => $getProduct->title,
            'quantity' => $request->qty,
            'price' => $total,
            'attributes' => [
                'size_id' => $size_id,
                'colour_id' => $colour_id,
            ]
        ]);

        return redirect()->back()->with('success', 'Product added to cart!');
    }


    public function updateCart(Request $request)
    {
        foreach ($request->cart as $cart) {
            Cart::update($cart['id'], array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $cart['qty']
                )
                
            )
            );
        }
        return redirect()->back();
    }

    public function deleteCartItem(Request $request)
    {
        Cart::remove($request->rowId);
        return redirect()->back();
    }

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
            'last_name' => trim($request->last_name),
            'email' => trim($request->email),
            'phone' => trim($request->phone),
            'password' => Hash::make($request->password),
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
        $colour = ColourModel::getSingleRecord($cartItem->attributes['colour_id'] ?? null);
        $size = ProductSizesModel::getSingleRecord($cartItem->attributes['size_id'] ?? null);

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

public function orderSuccess(Request $request, $encoded)
{
    $decoded = json_decode(base64_decode($encoded), true);
    $order_id = $decoded['order_id'] ?? null;

    if (!$order_id) {
        abort(404, 'Invalid order reference.');
    }

    $order = OrdersModel::getSingleRecord($order_id);

    if (empty($order)) {
        abort(404, 'Order not found.');
    }

    if (Cart::getSubTotal() <= 0 || Cart::isEmpty()) {
        return redirect()->route('cart')->with('error', 'Your cart is empty. Cannot complete payment.');
    }

    if ($order->payment_method === 'cash') {
        $order->is_payment = 1;
        $order->save();

        Cart::clear();

        return redirect()->route('cart')->with('success', 'Order placed successfully using Cash!');
    }

    if ($order->payment_method === 'wallet') {
        $user = User::getSingleRecord($order->user_id);
        if ($user && $user->wallet >= $order->total_amount) {
            $user->wallet -= $order->total_amount;
            $user->save();

            $order->is_payment = 1;
            $order->save();

            Cart::clear();

            return redirect()->route('cart')->with('success', 'Order placed successfully using Wallet!');
        } else {
            return redirect()->route('cart')->with('error', 'Insufficient wallet balance. Please top up your wallet.');
        }
    }

    abort(404, 'Unsupported payment method.');
}


}
