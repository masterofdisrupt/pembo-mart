@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shipping.charge') }}">Shipping Charges</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Discount Charge</h6>

                    <form method="POST" action="{{ route('shipping.charge.update', $shippingCharges->id) }}" class="forms-sample">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="code" class="col-sm-3 col-form-label">
                                Shipping Name <span class="text-danger">*</span>
                            </label>
                            
                                <input type="text" 
                                      
                                       name="name" 
                                       class="form-control @error('code') is-invalid @enderror"
                                       value="{{ old('name', $shippingCharges->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="discount_price" class="col-sm-3 col-form-label">
                                Shipping Price <span class="text-danger">*</span>
                            </label>
                            
                                <div class="input-group">
                                    <input type="number" 
                                           name="price" 
                                           class="form-control @error('price') is-invalid @enderror"
                                           value="{{ old('price', $shippingCharges->price) }}"
                                           required>
                                    <span class="input-group-text" id="price-addon"></span>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                          
                        </div>

                         <div class="mb-4">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" required>
                                <option value="1" {{ $shippingCharges->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $shippingCharges->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('shipping.charge') }}" class="btn btn-secondary me-2">
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