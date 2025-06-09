@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.slider') }}">Slider</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Create Slider</h6>
                    </div>

                    <form class="forms-sample" method="POST" action="{{ route('slider.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="col-sm-3 col-form-label">
                                Title <span class="text-danger"></span>
                            </label>
                          
                                <input type="text" 
                                       name="title"                            
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}"
                                       placeholder="Enter Title">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="image_name" class="col-sm-3 col-form-label">
                                Slider Image <span class="text-danger">*</span>
                            </label>
                           
                                <input type="file" 
                                       name="image_name" 
                                       class="form-control"
                                       required
                                >
                        </div>

                        <div class="mb-4">
                            <label for="button_name" class="col-sm-3 col-form-label">
                                Button Name <span class="text-danger"></span>
                            </label>
                          
                                <input type="text" 
                                       name="button_name"                            
                                       class="form-control @error('button_name') is-invalid @enderror"
                                       value="{{ old('button_name') }}"
                                       placeholder="Enter Button Name">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="button_link" class="col-sm-3 col-form-label">
                                Button Link <span class="text-danger"></span>
                            </label>
                          
                                <input type="text" 
                                       name="button_link"                            
                                       class="form-control @error('button_link') is-invalid @enderror"
                                       value="{{ old('button_link') }}"
                                       placeholder="Enter Button Link">
                                @error('button_link')
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
                            <a href="{{ route('admin.slider') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Slider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
