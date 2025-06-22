@extends('layouts.app')

@section('style')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 20px;
        display: inline-block;
    }
    .status-pending { background: #ffeeba; color: #856404; }
    .status-processing { background: #bee5eb; color: #0c5460; }
    .status-delivered { background: #c3e6cb; color: #155724; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-cancelled { background: #f8d7da; color: #721c24; }

    .table th, .table td {
        padding: 0.75rem 1rem;
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<main class="main">
    <div class="page-header text-center">
        <div class="container">
            <h1 class="page-title">Orders</h1>
        </div>
    </div>

    <div class="page-content py-4">
        <div class="dashboard">
            <div class="container">
                <div class="row">
                    @include('user._sidebar')

                    <div class="col-md-8 col-lg-9">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle" style="min-width: 100%;">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="min-width: 140px;">Order Number</th>
                                                <th>Total (₦)</th>
                                                <th>Payment Method</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($getOrders as $value)
                                                <tr>
                                                    <td style="word-break: break-word;">{{ $value->order_number }}</td>
                                                    <td>₦{{ number_format($value->total_amount, 2) }}</td>
                                                    <td class="text-capitalize">{{ $value->payment_method }}</td>
                                                    <td>
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
                                                        @endphp
                                                        <span class="status-badge {{ $statusClass[$value->status] ?? 'badge-secondary' }}">
                                                            {{ $statusLabel[$value->status] ?? 'Unknown' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ date('d-m-Y h:i A', strtotime($value->created_at)) }}</td>
                                                    <td>
                                                        <a href="{{ route('user.orders.view', $value->id) }}" class="btn btn-sm btn-outline-primary">
                                                            View Details
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">No records found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    {!! $getOrders->appends(request()->except('page'))->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
@endsection
