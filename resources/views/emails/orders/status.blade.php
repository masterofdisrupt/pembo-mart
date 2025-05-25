@component('mail::message')

# Order Update Notification

Dear {{ $order->first_name }},

@switch($order->status)
    @case(0)
We have received your order and it is currently being processed.  
We will notify you once it is ready for delivery.
        @break

    @case(1)
Thank you for your order with **Pembo Mart**!  
We are currently processing it and will notify you when it's ready for delivery.
        @break

    @case(2)
Your order is ready and on its way to you!
@if($order->tracking_number)
  
**Tracking Number:** {{ $order->tracking_number }}
@endif
        @break

    @case(3)
Your order has been **completed**. We hope you enjoy your purchase!
        @break

    @case(4)
Your order has been **cancelled**. If you have any questions or concerns, please contact our support team.
        @break
@endswitch

---

## Order Summary:

- **Order Number:** {{ $order->order_number }}
- **Order Date:** {{ $order->created_at->format('M d, Y') }}
- **Total Amount:** ₦{{ number_format($order->total_amount, 2) }}

If you have any questions about your order, feel free to reach out to our support team.

Thank you for shopping with **Pembo Mart**!

---

© {{ date('Y') }} Pembo Mart. All rights reserved.

@endcomponent
