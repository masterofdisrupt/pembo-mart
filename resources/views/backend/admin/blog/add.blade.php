@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Blog</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Blog</h6>

                        {{-- Display Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="forms-sample" method="POST" action="{{ route('store.blog') }}">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Title <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" id="getTitle" class="form-control" name="title"
                                        placeholder="Enter Title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Slug <span style="color: red;">*</span>
                                    <a href="javascript:;" id="ConvertSlug">Convert Slug</a></label>
                                <div class="col-sm-9">
                                    <input type="text" id="getSlug" class="form-control" name="slug"
                                        placeholder="Enter Slug" value="{{ old('slug') }}" required>
                                    @error('slug')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Description <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <textarea name="description" class="form-control editor" placeholder="Enter Description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('blog') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
