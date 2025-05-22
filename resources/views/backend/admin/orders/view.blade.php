@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('orders') }}">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Order</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-4">View Order</h6>

                    @php
                        $fields = [
                            'ID' => $getRecord->id,
                            'First Name' => $getRecord->first_name,
                            'Last Name' => $getRecord->last_name,
                            'Email' => $getRecord->email,
                            'Company Name' => $getRecord->company_name,
                            'Country' => $getRecord->country,
                            'Address' => $getRecord->address_one,
                            'City' => $getRecord->city,
                            'State' => $getRecord->state,
                            'Postcode' => $getRecord->postcode,
                            'Phone' => $getRecord->phone,
                            'Discount Code' => $getRecord->discount_code,
                            'Discount Amount (₦)' => number_format($getRecord->discount_amount, 2),
                            'Total Amount (₦)' => number_format($getRecord->total_amount, 2),
                            'Shipping Name' => optional($getRecord->getShipping)->name ?? 'N/A',
                            'Shipping Amount (₦)' => number_format($getRecord->shipping_amount, 2),
                            'Payment Method' => ucfirst($getRecord->payment_method),
                            'Payment Status' => $getRecord->is_payment ? 'Paid' : 'Unpaid',
                            'Created At' => date('d-m-Y H:i A', strtotime($getRecord->created_at)),
                        ];
                    @endphp

                    @foreach($fields as $label => $value)
                        <div class="row mb-3">
                            <div class="col-sm-3 fw-semibold text-muted">{{ $label }}:</div>
                            <div class="col-sm-9">{{ $value }}</div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="col-md-12 grid-margin stretch-card">
    <div class="card shadow-sm">
        <div class="card-body">
            <h6 class="card-title mb-4">Order Items</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price (₦)</th>
                            <th>Size</th>
                            <th>Colour</th>
                            <th>Size Amount (₦)</th>
                            <th>Total (₦)</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($getRecord->ordersDetails as $index => $item)
                            @php
                                $productImage = $item->getProduct->getImages()->first();
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($productImage)
                                        <img src="{{ $productImage->getProductImages() }}" width="60" height="60" alt="Product Image">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ optional($item->getProduct)->slug ? route('product.details', ['slug' => $item->getProduct->slug]) : '#' }}" target="_blank">
                                        {{ $item->getProduct->title ?? 'N/A' }}
                                    </a>

                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>₦{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->size_name ?? 'N/A' }}</td>
                                <td>{{ $item->colour_name ?? 'N/A' }}</td>
                                <td>₦{{ number_format($item->size_amount ?? 0, 2) }}</td>
                                <td>₦{{ number_format($item->total_price ?? 0, 2 ) }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    </div>
</div>
@endsection
