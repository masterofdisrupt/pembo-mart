@extends('backend.agent.agent_dashboard')

@section('agent')
<div class="page-content">
    
        @include('_message')

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('transactions') }}">Transactions</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Transactions</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Add Transactions</h6>

                    <form class="forms-sample" method="POST" action="{{ route('agent.transactions.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Order Number <span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="order_number" class="form-control" placeholder="Enter Order Number" required>
                                @error('order_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Transaction ID <span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="transaction_id" class="form-control" placeholder="Enter Transaction ID" required>
                                @error('transaction_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Amount <span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="amount" placeholder="Enter Amount" required>
                                @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Payment Status <span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                                <select name="is_payment" class="form-control" required>
                                    <option value="">Select Payment Status</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                                @error('is_payment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <a href="{{ route('transactions') }}" class="btn btn-secondary">Back</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection