@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shipping.charge') }}">Shipping Charges</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Create Shipping Charge</h6>
                    </div>

                    <form class="forms-sample" method="POST" action="{{ route('shipping.charge.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="col-sm-3 col-form-label">
                                Shipping Name <span class="text-danger">*</span>
                            </label>
                          
                                <input type="text" 
                                       name="name"                            
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('code') }}"
                                       placeholder="Enter Shipping Name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="price" class="col-sm-3 col-form-label">
                                Shipping Price <span class="text-danger">*</span>
                            </label>
                           
                                <input type="number" 
                                       name="price" 
                                       class="form-control @error('price') is-invalid @enderror"
                                       value="{{ old('price') }}"
                                       placeholder="Enter Shipping Price">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="status" class="col-sm-3 col-form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            
                                <select name="status" 
                                        id="status"
                                        class="form-select @error('status') is-invalid @enderror">
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="text-end">
                            <a href="{{ route('shipping.charge') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Shipping Charge
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
