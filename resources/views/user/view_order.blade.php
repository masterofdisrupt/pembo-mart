@extends('layouts.app')

@section('style')
<style>
   .dashboard .card {
        border-radius: 0.5rem;
    }
    .dashboard .card-body {
        padding: 1.25rem;
    }
    .dashboard .info-label {
        font-weight: 600;
        color: #6c757d;
    }
    .dashboard .info-row {
        margin-bottom: 0.6rem;
    }
    .dashboard .status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        user-select: none;
    }
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
        box-shadow: inset 0 0 5px rgba(133, 100, 4, 0.3);
    }
    .status-processing {
        background-color: #d1ecf1;
        color: #0c5460;
        box-shadow: inset 0 0 5px rgba(12, 84, 96, 0.3);
    }
    .status-delivered {
        background-color: #c3e6cb;
        color: #155724;
        box-shadow: inset 0 0 5px rgba(21, 87, 36, 0.3);
    }
    .status-completed {
        background-color: #d4edda;
        color: #155724;
        box-shadow: inset 0 0 5px rgba(21, 87, 36, 0.3);
    }
    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
        box-shadow: inset 0 0 5px rgba(114, 28, 36, 0.3);
    }

    .table-responsive {
        overflow-x: auto;
    }
    .table-bordered {
        border: 1px solid #dee2e6;
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }
    .table th, .table td {
        vertical-align: middle !important;
        padding: 0.75rem 1rem;
    }
    .table th {
    text-align: center;
    }

    .table a {
        color: #007bff;
        text-decoration: none;
    }
    .table a:hover {
        text-decoration: underline;
    }
    .text-muted {
        color: #6c757d !important;
    }

    /* Responsive for smaller devices */
    @media (max-width: 767.98px) {
        .dashboard .info-row {
            flex-direction: column;
            align-items: flex-start;
        }
        .dashboard .info-label {
            margin-bottom: 0.25rem;
        }
    }
</style>
@endsection

@section('content')
<main class="main">
    <div class="page-header text-center mb-3">
        <div class="container">
            <h1 class="page-title mb-1">Order Details</h1>
        </div>
    </div>

    <div class="page-content py-3">
        <div class="dashboard">
            <div class="container">
                <div class="row">
                    @include('user._sidebar')

                    <div class="col-md-8 col-lg-9">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="mb-3">Order Information</h5>

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
                                    <div class="row info-row">
                                        <div class="col-sm-4 info-label">{{ $label }}:</div>
                                        <div class="col-sm-8">{{ $value }}</div>
                                    </div>
                                @endforeach

                                <div class="row info-row">
                                    <div class="col-sm-4 info-label">Payment Status:</div>
                                    <div class="col-sm-8">
                                        <span class="status-badge {{ $statusClass[$getRecord->status] ?? 'badge-secondary' }}">
                                            {{ $statusLabel[$getRecord->status] ?? 'Unknown' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mt-4">
                            <div class="card-body">
                                <h6 class="card-title mb-4">Order Items</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Image</th>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Unit Price (₦)</th>
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
                                                    <td>
                                                        @if($productImage)
                                                            <img style="width: 80px; height: 80px;" src="{{ $productImage->getProductImages() }}" alt="{{ $item->getProduct->title ?? 'Product Image' }}">
                                                        @else
                                                            <span class="text-muted">No Image</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ optional($item->getProduct)->slug ? route('product.details', ['slug' => $item->getProduct->slug]) : '#' }}" target="_blank">
                                                            {{ $item->getProduct->title ?? 'N/A' }}
                                                        </a>
                                                        <br>
                                                        @if (!empty($item->size_name))
                                                            <b>Size:</b> {{ $item->size_name }} <br>
                                                        @endif

                                                        @if (!empty($item->colour_name))
                                                            <b>Colour:</b> {{ $item->colour_name }} <br>
                                                        @endif

                                                        @if ($getRecord->status == 3)
                                                            @php
                                                                $getReview = $item->getReview($item->getProduct->id, $getRecord->id);
                                                            @endphp

                                                            @if($getReview)
                                                                <b>How many Rating:</b> {{ $getReview->rating }} <br>
                                                                <b>Review:</b> {{ $getReview->review }} <br>
                                                            @else
                                                                <button class="btn btn-sm btn-primary make-review"
                                                                        data-product="{{ $item->getProduct->id }}"
                                                                        data-order="{{ $getRecord->id }}">
                                                                    Make Review
                                                                </button>
                                                            @endif
                                                        @endif


                                                    </td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>₦{{ number_format($item->price, 2) }}</td>
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
        </div> 
    </div> 
</main>

<!-- Modal -->
<div class="modal fade" id="makeReviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Make Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('user.make.review') }}" method="POST">
         @csrf
        <input type="hidden" name="product_id" id="getProductId" required>
        <input type="hidden" name="order_id" id="getOrderId" required>
       
      <div class="modal-body" style="padding: 20px;">
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="reviewContent">How many stars would you like to give? *</label>
            <select class="form-control" id="reviewContent" name="rating" required>
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
            </select>
        </div>

        <div class="form-group">
            <label for="reviewContent">Write your review: *</label>
            <textarea class="form-control" name="review" id="reviewContent" rows="4" placeholder="Write your review here..." required></textarea>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>

      </form>

    </div>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('.make-review').on('click', function() {
            var productId = $(this).data('product');
            var orderId = $(this).data('order');

            $('#getProductId').val(productId);
            $('#getOrderId').val(orderId);
            $('#makeReviewModal').modal('show');
        });

    });
</script>
@endsection
