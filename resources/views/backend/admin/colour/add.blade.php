@extends('backend.admin.admin_dashboard')
@section('admin')
<div class="page-content">
    
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('colour') }}">Colour</a></li>
            <li class="breadcrumb-item active">Add Colour</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Add Colour</h6>

                    <form class="forms-sample" method="POST" action="{{ route('colour.store') }}">
                        @csrf
                        
                       
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">
                                Name <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" 
                                       placeholder="Enter Name"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">
                                Code <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="color" 
                                    name="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code', '#000000') }}"
                                    style="height: 50px; padding: 5px;"
                                    required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                       
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="{{ route('colour') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection