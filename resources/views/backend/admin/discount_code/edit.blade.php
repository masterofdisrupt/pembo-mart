@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('discount.code') }}">Discount Codes</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Discount Code</h6>

                    <form method="POST" action="{{ route('discount.code.update', $discountCode->id) }}" class="forms-sample">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="user_id" class="col-sm-3 col-form-label">
                                User <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select name="user_id" id="user_id" 
                                        class="form-select @error('user_id') is-invalid @enderror" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" 
                                            {{ old('user_id', $discountCode->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->username }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="discount_code" class="col-sm-3 col-form-label">
                                Discount Code <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       id="discount_code"
                                       name="discount_code" 
                                       class="form-control @error('discount_code') is-invalid @enderror"
                                       value="{{ old('discount_code', $discountCode->discount_code) }}"
                                       placeholder="Enter discount code"
                                       required>
                                @error('discount_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="discount_price" class="col-sm-3 col-form-label">
                                Value <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="number" 
                                           id="discount_price"
                                           name="discount_price" 
                                           class="form-control @error('discount_price') is-invalid @enderror"
                                           value="{{ old('discount_price', $discountCode->discount_price) }}"
                                           min="0"
                                           max="100"
                                           step="0.01"
                                           required>
                                    <span class="input-group-text" id="price-addon"></span>
                                </div>
                                @error('discount_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="expiry_date" class="col-sm-3 col-form-label">
                                Expiry Date <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="date" 
                                id="expiry_date"
                                name="expiry_date" 
                                class="form-control @error('expiry_date') is-invalid @enderror"
                                value="{{ old('expiry_date', $expiryDate) }}"
                                min="{{ date('Y-m-d') }}"
                                required>
                                @error('expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="type" class="col-sm-3 col-form-label">
                                Type <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select name="type" id="type" 
                                        class="form-select @error('type') is-invalid @enderror" required>
                                    @foreach ($types as $value => $label)
                                        <option value="{{ $value }}" 
                                            {{ old('type', $discountCode->type) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="usages" class="col-sm-3 col-form-label">
                                Usage <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select name="usages" id="usages" 
                                        class="form-select @error('usages') is-invalid @enderror" required>
                                    @foreach ($usages as $value => $label)
                                        <option value="{{ $value }}" 
                                            {{ old('usages', $discountCode->usages) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('usages')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('discount.code') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Changes
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
document.getElementById('type').addEventListener('change', function() {
    const priceAddon = document.getElementById('price-addon');
    const priceInput = document.getElementById('discount_price');
    
    if (this.value === '0') {
        priceAddon.textContent = '%';
        priceInput.max = '100';
    } else {
        priceAddon.textContent = '₱';
        priceInput.removeAttribute('max');
    }
});

// Trigger change event to set initial state
document.getElementById('type').dispatchEvent(new Event('change'));
</script>
@endpush