<?php 

namespace App\Services;

use App\Models\Backend\V1\OrdersModel;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\OrderInvoiceMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Hash;
use Cart;

class OrderPaymentService
{
    public function processOrderSuccess(\Illuminate\Http\Request $request, string $encoded)
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

    if ($order->is_payment == 1) {
        return redirect()->route('cart')->with('info', 'This order has already been processed.');
    }

    if (Cart::getSubTotal() <= 0 || Cart::isEmpty()) {
        return redirect()->route('cart')->with('error', 'Your cart is empty. Cannot complete payment.');
    }

    if ($order->payment_method === 'cash') {
        $order->is_payment = 1;
        $order->save();

        $this->sendOrderInvoiceEmail($order);


        Cart::clear();

        return redirect()->route('cart')->with('success', 'Order placed successfully using Cash!');
    }

    if ($order->payment_method === 'wallet') {
        $user = User::getSingle($order->user_id);

        if ($user && $user->wallet >= $order->total_amount) {
            $user->wallet -= $order->total_amount;
            $user->save();

            $order->is_payment = 1;
            $order->save();

            $this->sendOrderInvoiceEmail($order);

            Cart::clear();

            return redirect()->route('cart')->with('success', 'Order placed successfully using Wallet!');
        }

        return redirect()->route('cart')->with('error', 'Insufficient wallet balance. Please top up your wallet.');
    }

    abort(404, 'Unsupported payment method.');
}

  protected function sendOrderInvoiceEmail($order)
{
    if (!$order || !$order->user || !$order->user->email) {
        return;
    }

    Mail::to($order->user->email)->send(new OrderInvoiceMail($order));
}


}