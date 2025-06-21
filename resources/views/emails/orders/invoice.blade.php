@component('mail::message')

@php
    $getSetting = \App\Models\SystemSetting::getSingleRecord();
    $websiteName = $getSetting->website;
@endphp

# Order Invoice

Hi {{ $order->first_name ?? 'Customer' }},

Thank you for your order with **{{ $websiteName }}**. Below are your order details:

---

**Order Number:** #{{ $order->order_number }}  
**Order Date:** {{ $order->created_at->format('d M, Y h:i A') }}  
**Payment Method:** {{ ucfirst($order->payment_method) }}  
---

### Items Ordered:
@foreach ($order->ordersDetails as $item)
- **{{ $item->getProduct ? $item->getProduct->title : 'Product not found' }}** (x{{ $item->quantity }})   
    @if ($item->size_name)
        Size: {{ $item->size_name }}
    @endif
    <br>
    @if ($item->colour_name)
        Colour: {{ $item->colour_name }}
    @endif
    <br>
    @if ($item->size_amount > 0)
        Size Amount: ₦{{ number_format($item->size_amount, 2) }}
    @endif
    <br>

    Total Amount: ₦{{ number_format($item->total_price, 2) }}
@endforeach

---

**Discount Code:** {{ $order->discount_code ?? 'N/A' }}

@php
    $taxRate = 0.075;
    $total = $order->total_amount;
    $delivery = $order->shipping_fee;
    $discount = $order->discount_amount ?? 0;
    $preTaxTotal = ($total - $delivery + $discount) / (1 + $taxRate);
    $tax = $preTaxTotal * $taxRate;
    $subtotal = $preTaxTotal;
@endphp

**Subtotal (before tax):** ₦{{ number_format($subtotal, 2) }}  
**VAT (7.5%):** ₦{{ number_format($tax, 2) }}  
@if ($discount > 0)
**Discount:** -₦{{ number_format($discount, 2) }}  
@endif
**Delivery Fee:** ₦{{ number_format($delivery, 2) }}  
**Total:** **₦{{ number_format($total, 2) }}**


---

### Delivery Address: {{ $order->address_one ?? 'N/A' }}, {{ $order->address_two ?? '' }}, {{ $order->city ?? 'N/A' }}, {{ $order->state ?? 'N/A' }}, {{ $order->country ?? 'N/A' }}
### Delivery Type: {{ $order->getShipping->name ?? 'Standard Delivery' }}

---

If you have any questions or concerns, please contact our support.

Thanks,  
**{{ $websiteName }} Team**

@component('mail::button', ['url' => route('user.orders')])
View My Orders
@endcomponent
@endcomponent
