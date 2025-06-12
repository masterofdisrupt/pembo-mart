@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('blog.category') }}">Blog Category</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Blog Category</h6>


                        <form class="forms-sample" method="POST" action="{{ route('blog.category.update', $getRecord->id) }}">
                            @csrf
                            @method('PUT')

                             <div class="mb-4">
                                <label for="name" class="col-sm-3 col-form-label">
                                    Category Name<span class="text-danger">*</span>
                                </label>
                                
                                    <input type="text" 
                                        
                                        name="name" 
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('name', $getRecord->name) }}" required
                                            placeholder="Enter Category Name"
                                        >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <div class="mb-4">
                                <label for="slug" class="col-sm-3 col-form-label">
                                    Slug<span class="text-danger">*</span>
                                </label>
                                
                                    <input type="text" 
                                        
                                        name="slug" 
                                        class="form-control @error('slug') is-invalid @enderror"
                                        value="{{ old('slug', $getRecord->slug) }}" required
                                            placeholder="Enter Slug Example URL"
                                        >
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <div class="mb-4">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" required>
                                <option value="1" {{ $getRecord->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="2" {{ $getRecord->status == 2 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                            <hr>

                            <div class="mb-4">
                                <label for="meta_title" class="col-sm-3 col-form-label">
                                    Meta Title<span class="text-danger">*</span>
                                </label>
                            
                                    <input type="text" 
                                        name="meta_title"                            
                                        class="form-control @error('meta_title') is-invalid @enderror"
                                        value="{{ old('meta_title', $getRecord->meta_title) }}"
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
                                    
                                >{{ old('meta_description', $getRecord->meta_description) }}</textarea>
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
                                        value="{{ old('meta_title', $getRecord->meta_keywords) }}"
                                        placeholder="Enter Meta Keywords"
                                        >
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            <a href="{{ route('blog.category') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
