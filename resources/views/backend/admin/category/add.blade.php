@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('category') }}">Category</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">Create Category</h6>
                        </div>

                        <form class="forms-sample" method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="col-sm-3 col-form-label">
                                    Category Name <span class="text-danger">*</span>
                                </label>
                            
                                    <input type="text" 
                                        name="name"                            
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}"
                                        placeholder="Enter Category Name"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <div class="mb-4">
                                <label for="name" class="col-sm-3 col-form-label">
                                    Slug<span class="text-danger">*</span>
                                </label>
                            
                                    <input type="text" 
                                        name="slug"                            
                                        class="form-control @error('slug') is-invalid @enderror"
                                        value="{{ old('slug') }}"
                                        placeholder="Enter Slug Example URL"
                                        required>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <div class="mb-4">
                                <label for="status" class="col-sm-3 col-form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                
                                    <select name="status" 
                                            id="status"
                                            class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <hr>

                             <div class="mb-4">
                                <label for="image_name" class="col-sm-3 col-form-label">
                                    Image <span class="text-danger"></span>
                                </label>
                                    <input type="file" 
                                        name="image_name" 
                                        class="form-control"
                                    >
                            </div>

                            <div class="mb-4">
                                <label for="button_name" class="col-sm-3 col-form-label">
                                    Button Name<span class="text-danger"></span>
                                </label>
                            
                                    <input type="text" 
                                        name="button_name"                            
                                        class="form-control @error('button_name') is-invalid @enderror"
                                        value="{{ old('button_name') }}"
                                        placeholder="Enter Button Name"
                                        required>
                                    @error('button_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <div class="mb-4 form-check">
                                <label for="is_home" class="form-check-label">
                                    Home Screen<span class="text-danger"></span>
                                </label>
                            
                                    <input type="checkbox" 
                                        name="is_home"                            
                                        class="form-check-input @error('is_home') is-invalid @enderror"
                                        {{ old('is_home') ? 'checked' : '' }}
                                    >
                                    @error('is_home')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <div class="mb-4 form-check">
                                <label for="is_menu" class="form-check-label">
                                    Menu<span class="text-danger"></span>
                                </label>
                            
                                    <input type="checkbox" 
                                        name="is_menu"                            
                                        class="form-check-input @error('is_menu') is-invalid @enderror"
                                        {{ old('is_menu') ? 'checked' : '' }}
                                    >
                                    @error('is_menu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <hr>

                            <div class="mb-4">
                                <label for="meta_title" class="col-sm-3 col-form-label">
                                    Meta Title<span class="text-danger">*</span>
                                </label>
                            
                                    <input type="text" 
                                        name="meta_title"                            
                                        class="form-control @error('meta_title') is-invalid @enderror"
                                        value="{{ old('meta_title') }}"
                                        placeholder="Enter Meta Title"
                                        required>
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <div class="mb-4">
                                <label for="meta_description" class="col-sm-3 col-form-label">
                                    Meta Description<span class="text-danger"></span>
                                </label>

                                <textarea 
                                    name="meta_description"
                                    id="meta_description"
                                    class="form-control @error('meta_description') is-invalid @enderror"
                                    placeholder="Enter Meta Description"
                                >{{ old('meta_description') }}</textarea>

                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-4">
                                <label for="meta_title" class="col-sm-3 col-form-label">
                                    Meta Keywords<span class="text-danger"></span>
                                </label>
                            
                                    <input type="text" 
                                        name="meta_title"                            
                                        class="form-control @error('meta_keywords') is-invalid @enderror"
                                        value="{{ old('meta_keywords') }}"
                                        placeholder="Enter Meta Keywords"
                                        required>
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                             <div class="text-end">
                                <a href="{{ route('category') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Category
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
