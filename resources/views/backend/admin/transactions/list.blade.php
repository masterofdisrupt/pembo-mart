@extends('backend.admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        @include('_message')
        <nav class="page-breadcrumb">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Transactions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Transactions List</li>
            </ol>
        </nav>

        {{-- Search Start --}}
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Search Transactions</h6>
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label class="form-label">ID</label>
                                        <input type="text" name="id" class="form-control"
                                            value="{{ request()->id }}" placeholder="Enter ID">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="user_id" class="form-control"
                                            value="{{ request()->user_id }}" placeholder="Enter Username">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Order Number</label>
                                        <input type="text" name="order_number" class="form-control"
                                            value="{{ request()->order_number }}" placeholder="Enter Order Number">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Transaction Name</label>
                                        <input type="text" name="transaction_id" class="form-control"
                                            value="{{ request()->transaction_id }}" placeholder="Enter Transaction Name">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Amount</label>
                                        <input type="text" name="amount" class="form-control"
                                            value="{{ request()->amount }}" placeholder="Enter Amount">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Payment Status</label>
                                        <select name="is_payment" class="form-control">
                                            <option value="">Select Payment Status</option>
                                            <option {{ request()->is_payment == '0' ? 'selected' : '' }} value="0">
                                                Pending</option>
                                            <option {{ request()->is_payment == '1' ? 'selected' : '' }} value="1">
                                                Completed</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Created At</label>
                                        <input type="date" name="created_at" class="form-control"
                                            value="{{ request()->created_at }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Updated At</label>
                                        <input type="date" name="updated_at" class="form-control"
                                            value="{{ request()->updated_at }}">
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('transactions') }}" class="btn btn-danger">Reset</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        {{-- Search End --}}

        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h4 class="card-title">Transactions List</h4>
                            <div class="d-flex align-items-center">
                                
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
                                            <a class="btn btn-primary me-2" href="{{ route('transactions.edit', $value->id) }}">
                                                <span>Edit</span>
                                            </a>
                                            <form action="{{ route('transactions.delete', $value->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete?');" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <span>Delete</span>
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
