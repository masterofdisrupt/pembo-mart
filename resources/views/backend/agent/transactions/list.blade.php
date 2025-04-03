@extends('backend.agent.agent_dashboard')

@section('agent')
    <div class="page-content">
        @include('_message')
        <nav class="page-breadcrumb">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Transactions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Transactions List</li>
            </ol>
        </nav>

  
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h4 class="card-title">Transactions List</h4>
                            <div class="d-flex align-items-center">

                                <a href="{{ route('agent.transactions') }}" class="btn btn-primary">
                                    Add Transactions
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Order Number</th>
                                        <th>Transaction Name</th>
                                        <th>Amount</th>
                                        <th>Payment Status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalPrice = 0;
                                    @endphp
                                    @forelse ($getRecord as $value)
                                        @php
                                            $totalPrice = $totalPrice + $value->amount;
                                        @endphp
                                        <tr class="table-info text-dark">
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->user->name }}</td>
                                            <td>{{ $value->order_number }}</td>
                                            <td>{{ $value->transaction_id }}</td>
                                            <td>{{ $value->amount }}</td>
                                            <td>
                                            @if ($value->is_payment == 1)
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-primary">Pending</span>
                                            @endif
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($value->updated_at)) }}</td>
                                            <td>
                                                <form action="{{ route('transactions.destroy', $value->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm btn btn-delete"
                                                        data-item-name="transaction">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%">No Record Found.</td>
                                        </tr>
                                    @endforelse

                                @if (!empty($totalPrice))
                                    <tr>
                                        <th colspan="4">Total Amount</th>
                                        <td>{{ number_format($totalPrice, 2) }}</td>
                                        <th colspan="4"></th>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div style="padding: 20px; float: right;">
                        {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
