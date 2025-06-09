@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">
    @include('_message')

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.slider') }}">Slider</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Slider</h6>

                    <form method="POST" action="{{ route('update.slider', $getRecord->id) }}" enctype="multipart/form-data" class="forms-sample">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="col-sm-3 col-form-label">
                                Title <span class="text-danger"></span>
                            </label>
                            
                                <input type="text" 
                                      
                                       name="title" 
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('name', $getRecord->title) }}"
                                >
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                        <div class="mb-4">
                            <label for="image_name" class="col-sm-3 col-form-label">
                                Slider Image <span class="text-danger">*</span>
                            </label>
                            
                                <div class="input-group">
                                    <input type="file" 
                                           name="image_name" 
                                           class="form-control"
                                           required
                                    >
                                </div>
                               @if (!empty($getRecord->getSliderImage()))
                                    <div class="mt-2">
                                        <img src="{{ $getRecord->getSliderImage() }}" 
                                             alt="Slider Image" 
                                             class="img-fluid" 
                                             style="max-width: 200px;">
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <span class="text-danger">No image uploaded</span>
                                    </div>
                                   
                               @endif
                          
                        </div>

                         <div class="mb-4">
                            <label for="button_name" class="col-sm-3 col-form-label">
                                Button Name <span class="text-danger"></span>
                            </label>
                            
                                <input type="text" 
                                      
                                       name="button_name" 
                                       class="form-control @error('button_name') is-invalid @enderror"
                                       value="{{ old('button_name', $getRecord->button_name) }}"
                                       >
                                @error('button_name')
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
                                       value="{{ old('button_link', $getRecord->button_link) }}"
                                       >
                                @error('button_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            
                        </div>

                         <div class="mb-4">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" required>
                                <option value="1" {{ $getRecord->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $getRecord->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.slider') }}" class="btn btn-secondary me-2">
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