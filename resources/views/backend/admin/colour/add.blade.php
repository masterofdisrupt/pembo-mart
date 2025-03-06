@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('colour') }}">Colour</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Colour</li>
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
                                <label class="col-sm-3 col-form-label">Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" 
                                    value="{{ old('name') }}" placeholder="Enter Name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('colour') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
