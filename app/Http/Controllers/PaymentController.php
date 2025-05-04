<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Backend\V1\ProductModel;
use App\Models\Backend\V1\ProductSizesModel;
use Cart;

class PaymentController extends Controller
{
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
            $total = $total + $size_price;
            
        } else {
            $size_id = 0;
        }

        $color_id = !empty($request->color_id) ? $request->color_id : 0;

        Cart::add([
            'id' => $getProduct->id,
            'name' => 'product_name',
            'quantity' => $request->qty,
            'price' => $total,
            'options' => [
                'size_id' => $size_id,
                'color_id' => $color_id,
            ]
        ]);
        
        // dd($request->all());

        return redirect()->back();
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

}
