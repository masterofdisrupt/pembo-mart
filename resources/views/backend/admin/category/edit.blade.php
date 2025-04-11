@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('category') }}">Category</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Category</h6>


                        <form class="forms-sample" method="POST" action="{{ route('category.update', $getRecord->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Category Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Enter Category Name" value="{{ old('name', $getRecord->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                             <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Slug <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="slug"
                                        placeholder="Enter Slug Example URL" value="{{ old('slug', $getRecord->slug) }}" required>
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                             <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Status <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select name="status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="1" {{ old('status', $getRecord->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="2" {{ old('status', $getRecord->status) == 2 ? 'selected' : '' }}>Inactive</option>
                                        
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Meta Title <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="meta_title"
                                        placeholder="Enter Meta Title" value="{{ old('meta_title', $getRecord->meta_title) }}" required>
                                    @error('meta_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Meta Description</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="meta_description"
                                        placeholder="Enter Meta Description" value="{{ old('meta_description', $getRecord->meta_description) }}"></textarea>
                                    @error('meta_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Meta Keywords</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="meta_keywords"
                                        placeholder="Enter Meta Keywords" value="{{ old('meta_keywords', $getRecord->meta_keywords) }}">
                                    @error('meta_keywords')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('category') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
