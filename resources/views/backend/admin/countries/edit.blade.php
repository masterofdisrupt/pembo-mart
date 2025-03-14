@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('countries') }}">Countries</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Countries</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Countries</h6>

                        <form class="forms-sample" method="POST" action="{{ route('countries.update', $getRecord->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Country Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $getRecord->name) }}" placeholder="Enter Country Name" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Country Code <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="code"
                                        placeholder="Enter Country Code" value="{{ old('code', $getRecord->code) }}" required>
                                    @error('code')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            <a href="{{ route('countries') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
