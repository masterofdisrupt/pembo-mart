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
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderPlacementService;
use App\Services\OrderPaymentService;
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
        'meta_title' => 'Checkout | Healthy, Affordable Student Meals – Soeatable',
        'meta_description' => 'Complete your order for healthy and budget-friendly meals delivered straight to your campus. Fast, easy, and nutritious – only on Soeatable.',
        'meta_keywords' => 'student meal checkout, healthy food delivery, affordable student meals, campus food, soeatable order'

    ];
    $shippingCharges = ShippingChargesModel::getActiveRecords();
    $paymentSetting = PaymentSetting::getSingleRecord();

    return view('payments.checkout', [
        'meta_title' => $metaData['meta_title'],
        'meta_description' => $metaData['meta_description'],
        'meta_keywords' => $metaData['meta_keywords'],
        'shippingCharges' => $shippingCharges,
        'cartItems' => $cartItems,
        'paymentSetting' => $paymentSetting
    ]);
}


    public function cart(Request $request)
    {
        $metaData = [
            'meta_title' => 'Your Cart | Soeatable – Affordable Healthy Meals for Students',
            'meta_description' => 'Review your selected healthy meals before checkout. Soeatable delivers fresh, affordable dishes made for students, right to your campus.',
            'meta_keywords' => 'student meal cart, healthy food for students, affordable meals, soeatable cart, campus food delivery'

        ];

        return view('payments.cart', [
            'meta_title' => $metaData['meta_title'],
            'meta_description' => $metaData['meta_description'],
            'meta_keywords' => $metaData['meta_keywords']
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

  public function placeOrder(Request $request, OrderPlacementService $orderService)
{
    return $orderService->placeOrder($request);
}

public function orderSuccess(Request $request, $encoded)
{
    return app(OrderPaymentService::class)->processOrderSuccess($request, $encoded);
}

}
