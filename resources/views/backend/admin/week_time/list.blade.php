@extends('backend.admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        @include('_message')
        <nav class="page-breadcrumb">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Week Time</a></li>
                <li class="breadcrumb-item active" aria-current="page">Week Time List</li>
            </ol>
        </nav>

        {{-- Search Start --}}
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Search Week Time</h6>
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label for="" class="form-label">ID</label>
                                        <input type="text" name="id" class="form-control"
                                            value="{{ Request()->id }}" placeholder="Enter ID">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Week Time Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ Request()->name }}" placeholder="Enter Week Time Name">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('week.time.list') }}" class="btn btn-danger">Reset</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Search End --}}

        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h4 class="card-title">Week Time List</h4>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('week.time.add') }}" class="btn btn-primary">
                                    Add Week Time
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($getRecord as $value)
                                        <tr class="table-info text-dark">
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>

                                            <td>


                                                <a class="dropdown-item"
                                                    href="{{ route('week.time.edit', $value->id) }}"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit-2 icon-sm me-2">
                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                        </path>
                                                    </svg> <span class="">Edit</span></a>

                                                
                                                 <form action="{{ route('week.time.delete', $value->id) }}" 
                                                    method="POST" class="d-inline-block delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item d-flex align-items-center btn-delete"
                                                        data-item-name="week time" style="border: none; background: none; cursor: pointer;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-trash-2 icon-sm me-2">
                                                            <path d="M21 4H8l-1 1H2v2h1l1 14h16l1-14h1V5a1 1 0 0 0-1-1z">
                                                            </path>
                                                            <line x1="3" y1="6" x2="21" y2="6"></line>
                                                        </svg> <span class="">Delete</span>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
