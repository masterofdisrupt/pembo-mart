@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">Create Blog</h6>
                        </div>

                        <form class="forms-sample" method="POST" action="{{ route('store.blog') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="title" class="col-sm-3 col-form-label">
                                    Title<span class="text-danger">*</span>
                                </label>
                            
                                    <input type="text" 
                                        name="title"                            
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}"
                                        placeholder="Enter Meta Title"
                                        required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <div class="mb-4">
                                <label for="category_id" class="col-form-label">
                                    Category Name <span class="text-danger">*</span>
                                </label>
                                <select name="blog_category_id"
                                        id="blog_category_id"
                                        class="form-select @error('blog_category_id') is-invalid @enderror" 
                                        required>
                                    <option value="">Select Category</option>
                                    @foreach($getCategory as $category)
                                        <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('blog_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="image_name" class="col-form-label">
                                    Image <span class="text-danger">*</span>
                                </label>
                                <input type="file" 
                                    name="image_name"
                                    id="image_name"
                                    class="form-control @error('image_name') is-invalid @enderror"
                                    required>
                                @error('image_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="short_description" class="col-form-label">
                                    Short Description <span class="text-danger">*</span>
                                </label>
                                <textarea 
                                    name="short_description"
                                    id="short_description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter Short Description"
                                    required>{{ old('short_description') }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="col-form-label">
                                    Description <span class="text-danger">*</span>
                                </label>
                                <textarea 
                                    name="description"
                                    id="description"
                                    class="form-control editor @error('description') is-invalid @enderror"
                                    placeholder="Enter Description"
                                    required>{{ old('description') }}</textarea>
                                @error('description')
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
                                <label for="meta_keywords" class="col-sm-3 col-form-label">
                                    Meta Keywords<span class="text-danger"></span>
                                </label>
                            
                                    <input type="text" 
                                        name="meta_keywords"                            
                                        class="form-control @error('meta_keywords') is-invalid @enderror"
                                        value="{{ old('meta_keywords') }}"
                                        placeholder="Enter Meta Keywords"
                                        >
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                             <div class="text-end">
                                <a href="{{ route('blog.category') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Blog
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
