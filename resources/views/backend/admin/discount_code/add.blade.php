@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('discount.code') }}">Discount Codes</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Create Discount Code</h6>
                    </div>

                    <form class="forms-sample" method="POST" action="{{ route('discount.code.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="code" class="col-sm-3 col-form-label">
                                Discount Code <span class="text-danger">*</span>
                            </label>
                          
                                <input type="text" 
                                       name="code" 
                                       
                                       class="form-control @error('code') is-invalid @enderror"
                                       value="{{ old('code') }}"
                                       placeholder="Enter discount code">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="discount_price" class="col-sm-3 col-form-label">
                                Discount Value <span class="text-danger">*</span>
                            </label>
                           
                                <input type="number" 
                                       name="discount_price" 
                                       id="discount_price"
                                       class="form-control @error('discount_price') is-invalid @enderror"
                                       value="{{ old('discount_price') }}"
                                       min="0" 
                                       max="100" 
                                       step="0.01"
                                       placeholder="Enter discount value">
                                @error('discount_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="expiry_date" class="col-sm-3 col-form-label">
                                Expiry Date <span class="text-danger">*</span>
                            </label>
                            
                                <input type="date" 
                                       name="expiry_date" 
                                       id="expiry_date"
                                       class="form-control @error('expiry_date') is-invalid @enderror"
                                       value="{{ old('expiry_date') }}"
                                       min="{{ date('Y-m-d') }}">
                                @error('expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="type" class="col-sm-3 col-form-label">
                                Type <span class="text-danger">*</span>
                            </label>
                            
                                <select name="type" 
                                        id="type"
                                        class="form-select @error('type') is-invalid @enderror">
                                    <option value="0" {{ old('type') == '0' ? 'selected' : '' }}>Percentage (%)</option>
                                    <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>Fixed Amount</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                           
                        </div>

                        <div class="mb-4">
                            <label for="usages" class="col-sm-3 col-form-label">
                                Usage <span class="text-danger">*</span>
                            </label>
                            
                                <select name="usages" 
                                        id="usages"
                                        class="form-select @error('usages') is-invalid @enderror">
                                    <option value="1" {{ old('usages') == '1' ? 'selected' : '' }}>Unlimited</option>
                                    <option value="0" {{ old('usages') == '0' ? 'selected' : '' }}>One Time</option>
                                </select>
                                @error('usages')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        
                        </div>

                        <div class="text-end">
                            <a href="{{ route('discount.code') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Discount Code
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Dynamic max value for discount price based on type
    document.getElementById('type').addEventListener('change', function() {
        const priceInput = document.getElementById('discount_price');
        if (this.value === '0') { // Percentage
            priceInput.setAttribute('max', '100');
        } else { // Fixed amount
            priceInput.removeAttribute('max');
        }
    });
</script>
@endpush