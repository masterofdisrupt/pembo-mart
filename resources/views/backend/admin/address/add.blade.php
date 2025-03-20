@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.address') }}">Address</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Address</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Address</h6>

                        <form class="forms-sample" method="POST" action="{{ route('admin.address.store') }}">
                            @csrf
                            
                            {{-- Country Dropdown --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Country Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select id="country_add" name="country_id" class="form-control" required>
                                        <option value="">Select Country</option>
                                        @foreach ($getRecord as $value)
                                            <option value="{{ $value->id }}">{{ $value->country_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- State Dropdown --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">State Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select name="state_id" id="state_add" class="form-control" required>
                                        <option value="">Select State</option>
                                    </select>
                                    @error('state_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- City Dropdown --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">City Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select name="city_id" id="city_add" class="form-control" required>
                                        <option value="">Select City</option>
                                    </select>
                                    @error('city_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Address <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="address" class="form-control"
                                        placeholder="Enter Address" value="{{ old('address') }}" required>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Zip Code <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="number" name="zip_code" class="form-control"
                                        placeholder="Enter Zip Code" value="{{ old('zip_code') }}" required>
                                    @error('zip_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('admin.address') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection