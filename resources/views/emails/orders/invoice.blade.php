@component('mail::message')
# Order Invoice

Hi {{ $order->first_name ?? 'Customer' }},

Thank you for your order with **Pembo-Mart**. Below are your order details:

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
  @php 
    $lineTotal = $item->total_price * $item->quantity; 
  @endphp
  Price: ₦{{ number_format($lineTotal, 2) }}
@endforeach

---

**Discount Code:** {{ $order->discount_code ?? 'N/A' }}

@if ($order->discount_amount > 0)
**Discount Amount:** -₦{{ number_format($order->discount_amount, 2) }}  
@endif
**Delivery Fee:** ₦{{ number_format($order->shipping_fee, 2) }}  
**Total:** **₦{{ number_format($order->total_amount, 2) }}**

---

### Delivery Address: {{ $order->address_one ?? 'N/A' }}, {{ $order->address_two ?? '' }}, {{ $order->city ?? 'N/A' }}, {{ $order->state ?? 'N/A' }}, {{ $order->country ?? 'N/A' }}
### Delivery Type: {{ $order->getShipping->name ?? 'Standard Delivery' }}

---

If you have any questions or concerns, please contact our support.

Thanks,  
**Pembo-Mart Team**

@component('mail::button', ['url' => route('user.orders')])
View My Orders
@endcomponent
@endcomponent
