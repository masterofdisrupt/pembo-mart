@extends('backend.admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('product') }}">Product</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Product</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Product</h6>

                        <form class="forms-sample" method="POST" action="{{ route('product.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Title <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title" 
                                           placeholder="Enter Title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Price <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="price" 
                                           placeholder="Enter Price" value="{{ old('price') }}" step="0.01" required>
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Description <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="description" placeholder="Enter Description" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('product') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
