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
                        $statusClass = [
                            0 => 'status-pending',
                            1 => 'status-processing',
                            2 => 'status-delivered',
                            3 => 'status-completed',
                            4 => 'status-cancelled',
                        ];
                        $statusLabel = [
                            0 => 'Pending',
                            1 => 'Processing',
                            2 => 'Delivered',
                            3 => 'Completed',
                            4 => 'Cancelled',
                        ];

                        $fields = [
                            'Order Number' => $getRecord->order_number,
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
                            'Created At' => date('d-m-Y h:i A', strtotime($getRecord->created_at)),
                        ];
                    @endphp

                    @foreach($fields as $label => $value)
                        <div class="row info-row py-2 border-bottom">
                            <div class="col-sm-4 text-muted fw-medium">{{ $label }}:</div>
                            <div class="col-sm-8 text-body fw-semibold">{{ $value }}</div>
                        </div>
                    @endforeach

                    <div class="row info-row py-2">
                        <div class="col-sm-4 text-muted fw-medium">Payment Status:</div>
                        <div class="col-sm-8">
                            <span class="status-badge {{ $statusClass[$getRecord->status] ?? 'badge-secondary' }}">
                                {{ $statusLabel[$getRecord->status] ?? 'Unknown' }}
                            </span>
                        </div>
                    </div>
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
                                                <span class="text-muted">No Image</span>
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
@section('styles')
<style type="text/css">
    .info-row {
        margin-bottom: 0.5rem;
    }
    .status-badge {
        padding: 0.35em 0.75em;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
    }
    .status-pending { background-color: #ffc107; color: #000; }
    .status-processing { background-color: #17a2b8; color: #fff; }
    .status-delivered { background-color: #007bff; color: #fff; }
    .status-completed { background-color: #28a745; color: #fff; }
    .status-cancelled { background-color: #dc3545; color: #fff; }
</style>
@endsection
