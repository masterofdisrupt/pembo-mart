@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.pages') }}">Pages</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Pages</h6>

                    <form method="POST" action="{{ route('pages.update', $getPages->id) }}" 
                        class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="col-sm-3 col-form-label">
                                Name <span class="text-danger"></span>
                            </label>
                            
                                <input type="text" 
                                      
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $getPages->name) }}"
                                       placeholder="Enter Name" 
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="title" class="col-sm-3 col-form-label">
                                Title <span class="text-danger"></span>
                            </label>
                            
                                <input type="text" 
                                       name="title" 
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $getPages->title) }}"
                                       placeholder="Enter Title" 
                                >
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="image" class="col-sm-3 col-form-label">
                                Image <span class="text-danger"></span>
                            </label>
                            
                                <input type="file" 
                                       name="image" 
                                       class="form-control @error('image') is-invalid @enderror"
                                >
                                @if(!empty($getPages->getPageImages()))
                                <img style="width: 100px;" src="{{ $getPages->getPageImages() }}">
                                @endif
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="description" class="col-sm-3 col-form-label">
                                Description <span class="text-danger"></span>
                            </label>
                            
                                <textarea type="text" 
                                      
                                       name="description" 
                                       class="form-control editor @error('description') is-invalid @enderror"
                                       placeholder="Enter Description" 
                                >{{ old('description', $getPages->description) }}</textarea>
                                
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="meta_title" class="col-sm-3 col-form-label">
                                Meta Title <span class="text-danger"></span>
                            </label>
                            
                                <input type="text" 
                                      
                                       name="meta_title" 
                                       class="form-control @error('meta_title') is-invalid @enderror"
                                       value="{{ old('meta_title', $getPages->meta_title) }}"
                                       placeholder="Enter Meta Title" 
                                >
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="meta_description" class="col-sm-3 col-form-label">
                               Meta Description <span class="text-danger"></span>
                            </label>
                            
                                <textarea type="text" 
                                      
                                       name="meta_description" 
                                       class="form-control @error('description') is-invalid @enderror"
                                       placeholder="Enter Meta Description" 
                                >{{ old('meta_description', $getPages->meta_description) }}</textarea>
                                
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="meta_keywords" class="col-sm-3 col-form-label">
                                Meta Keywords <span class="text-danger"></span>
                            </label>
                            
                                <input type="text" 
                                      
                                       name="meta_keywords" 
                                       class="form-control @error('meta_keywords') is-invalid @enderror"
                                       value="{{ old('meta_keywords', $getPages->meta_keywords) }}"
                                       placeholder="Enter Meta Keywords" 
                                >
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>
                         

                        <div class="text-end">
                            <a href="{{ route('admin.pages') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$('.editor').tinymce({
        height: 500,
        menubar: false,
        plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | bold italic backcolor | \
                    alignleft aligncenter alignright alignjustify | \
                    bullist numlist outdent indent | removeformat | help'

    });

</script>
@endsection