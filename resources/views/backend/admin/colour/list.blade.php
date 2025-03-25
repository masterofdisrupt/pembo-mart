@extends('backend.admin.admin_dashboard')

@section('style')
    <style type="text/css">
        .switch {
            position: relative;
            display: inline-block;
            width: 3.75rem; /* 60px */
            height: 2.125rem; /* 34px */
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 2rem; /* 34px / 2 for border-radius */
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 1.625rem; /* 26px */
            width: 1.625rem; /* 26px */
            left: 0.25rem; /* 4px */
            bottom: 0.25rem; /* 4px */
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(2rem); /* 26px */
        }
    </style>
@endsection

@section('admin')
    <div class="page-content">
        @include('_message')
        <nav class="page-breadcrumb">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Colour</a></li>
                <li class="breadcrumb-item active" aria-current="page">Colour List</li>
            </ol>
        </nav>

        {{-- Search Box Start --}}
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Search Blog</h6>
                        <form action="">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label for="" class="form-label">ID</label>
                                        <input type="text" name="id" class="form-control"
                                            value="{{ request()->id }}" placeholder="Enter ID">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ request()->name }}" placeholder="Enter Name">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Created At</label>
                                        <input type="date" name="created_at" class="form-control"
                                            value="{{ request()->created_at }}">
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('colour') }}" class="btn btn-danger">Reset</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Search Box End --}}
        <br>

        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h4 class="card-title">Colour List</h4>
                            <div class="d-flex align-items-center">

                                <a href="{{ route('pdf.colour') }}" class="btn btn-info">
                                    PDF Colour
                                </a>
                                &nbsp;&nbsp;&nbsp;

                                <a href="{{ route('pdf') }}" class="btn btn-primary">
                                    PDF
                                </a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="{{ route('colour.add') }}" class="btn btn-primary">
                                    Add Colour
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($getRecord as $value)
                                        <tr class="table-info text-dark">
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="statusCheckbox" 
                                                    data-id="{{ $value->id }}" {{ $value->status ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>

                                            <td>
                                                <a href="{{ route('pdf.by.id', $value->id) }}"
                                                    class="btn btn-success">PDF</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('colour.edit', $value->id) }}"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit-2 icon-sm me-2">
                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                        </path>
                                                    </svg> <span class="">Edit</span></a>

                                                <form action="{{ route('colour.delete', $value->id) }}" 
                                                    method="POST" onsubmit="return confirm('Are you sure you want to delete?');" 
                                                    style="display:inline;">
                                                    
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item" style="border: none; background: none; cursor: pointer;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-trash icon-sm me-2">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    </svg>
                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%">No Record Found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div style="padding: 20px; float: right;">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
