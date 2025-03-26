@extends('backend.admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        @include('_message')
        
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('transactions') }}">Transactions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Transaction</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Edit Transaction</h6>

                        <form class="forms-sample" method="POST" action="{{ route('transactions.update', $getRecord->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="order_number" class="col-sm-3 col-form-label">Order Number <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" 
                                           name="order_number" 
                                           id="order_number"
                                           class="form-control @error('order_number') is-invalid @enderror"
                                           placeholder="Enter Order Number" 
                                           value="{{ old('order_number', $getRecord->order_number) }}" 
                                           required>
                                    @error('order_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="transaction_id" class="col-sm-3 col-form-label">Transaction ID <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" 
                                           name="transaction_id" 
                                           id="transaction_id"
                                           class="form-control @error('transaction_id') is-invalid @enderror"
                                           placeholder="Enter Transaction ID" 
                                           value="{{ old('transaction_id', $getRecord->transaction_id) }}" 
                                           required>
                                    @error('transaction_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="amount" class="col-sm-3 col-form-label">Amount <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="number" 
                                           name="amount" 
                                           id="amount"
                                           class="form-control @error('amount') is-invalid @enderror"
                                           placeholder="Enter Amount" 
                                           value="{{ old('amount', $getRecord->amount) }}" 
                                           step="0.01"
                                           required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="is_payment" class="col-sm-3 col-form-label">Payment Status <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select name="is_payment" 
                                            id="is_payment"
                                            class="form-control @error('is_payment') is-invalid @enderror" 
                                            required>
                                        <option value="0" {{ old('is_payment', $getRecord->is_payment) == '0' ? 'selected' : '' }}>Pending</option>
                                        <option value="1" {{ old('is_payment', $getRecord->is_payment) == '1' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('is_payment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                <a href="{{ route('transactions') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection