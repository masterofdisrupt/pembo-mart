@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        @include('_message')

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Customers</a></li>
                <li class="breadcrumb-item active" aria-current="page">Customer List</li>
            </ol>

            <div class="d-flex align-items-center">
                <a href="javascript:void(0)" class="btn btn-warning">
                   {{ $getRecord->where('status', 'active')->count() }}
                    Active
                </a>&nbsp;&nbsp;
                <a href="javascript:void(0)" class="btn btn-danger">
                    {{ $getRecord->where('status', 'inactive')->count() }}
                    In Active
                </a>&nbsp;&nbsp;
                <a href="javascript:void(0)" class="btn btn-success">
                   {{ $getRecord->total() }}
                    Total
                </a>
            </div>
        </nav>

        {{-- Search Box start --}}
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Search Customer</h6>
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Id</label>
                                        <input type="text" name="id" class="form-control"
                                            value="{{ Request()->id }}" placeholder="Enter id">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">First Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ Request()->name }}" placeholder="Enter First Name">
                                    </div>
                                </div>

                               
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Enter Email</label>
                                        <input type="text" name="email" value="{{ Request()->email }}"
                                            class="form-control" placeholder="Enter email id">
                                    </div>
                                </div>
                            
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Address</label>
                                        <input type="text" name="address" value="{{ Request()->address }}"
                                            class="form-control" placeholder="Enter address">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Start Date</label>
                                        <input type="date" name="start_date" value="{{ Request()->start_date }}"
                                            class="form-control" placeholder="Enter Start Date">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label for="" class="form-label">End Date</label>
                                        <input type="date" name="end_date" value="{{ Request()->end_date }}"
                                            class="form-control" placeholder="Enter End Date">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('admin.users') }}" class="btn btn-danger ms-2">Reset</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>

        {{-- Search Box end --}}

        <div class="form-group">
    <label for="user_name">Search Customer</label>
    <input type="text" 
           class="form-control" 
           id="user_name" 
           name="user_name" 
           placeholder="Start typing to search users...">
    <input type="hidden" id="user_id" name="user_id">
</div>

        <br>

        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h4 class="card-title">Customer List</h4>
                            
                        </div>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Surname</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Photo</th>
                                        <th>Phone</th>
                                        <th>Website</th>
                                        <th>Address</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($getRecord as $value)
                                        <tr class="table-info text-dark">
                                            <form class="a_form{{ $value->id }}" method="POST">
                                                {{ csrf_field() }}
                                                <td>{{ $value->id }}</td>
                                                <td style="min-width: 150px;">
                                                    <input type="hidden" name="edit_id" value="{{ $value->id }}">
                                                    <input type="text" class="form-control mb-2" name="edit_name"
                                                    value="{{ old('name', $value->name) }}">
                                                    <button type="button" class="btn btn-success btn-sm submitform" id="{{ $value->id }}">Save</button>
                                                </td>
                                                <td style="min-width: 150px;">
                                                    <input type="hidden" name="edit_id" value="{{ $value->id }}">
                                                    <input type="text" class="form-control mb-2" name="edit_middle_name"
                                                    value="{{ old('middle_name', $value->middle_name) }}">
                                                    <button type="button" class="btn btn-success btn-sm submitform" id="{{ $value->id }}">Save</button>
                                                </td>
                                                <td style="min-width: 150px;">
                                                    <input type="hidden" name="edit_id" value="{{ $value->id }}">
                                                    <input type="text" class="form-control mb-2" name="edit_surname"
                                                    value="{{ old('surname', $value->surname) }}">
                                                    <button type="button" class="btn btn-success btn-sm submitform" id="{{ $value->id }}">Save</button>
                                                </td>         
                                                <td>{{ $value->username }}</td>
                                                <td>{{ $value->email }}</td>
                                                <td>       
                                                    @if (!empty($value->getProfile()))
                                                    <a href="{{ $value->getProfile() }}" data-lightbox="example-set">
                                                        <img src="{{ $value->getProfile() }}" style="width: 100%; height: 100%;">
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $value->phone }}</td>
                                            <td>{{ $value->website }}</td>
                                            <td>{{ $value->address }}</td>
                                            <td>
                                                @if ($value->role === 'admin')
                                                    <span class="badge bg-info">Admin</span>
                                                @elseif ($value->role === 'agent')
                                                    <span class="badge bg-primary">Agent</span>
                                                @elseif ($value->role === 'user')
                                                    <span class="badge bg-success">User</span>
                                                @endif
                                            </td>
                                            <td>
                                                <select name="" class="form-control changeStatus" id="{{ $value->id }}" style="width: 170px;">
                                                    <option {{ $value->status === 'active' ? 'selected' : '' }} value="active">Active</option>
                                                    <option {{ $value->status === 'inactive' ? 'selected' : '' }} value="inactive">Inactive</option>
                                                </select>
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                            <td>
                                              

                                                
                                            </td>
                                        </form>

                                        <!-- DELETE FORM (SEPARATED) -->
                                        <td>
                                            <form action="{{ route('admin.users.delete', $value->id) }}" method="POST" class="d-inline-block delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item d-flex align-items-center btn-delete" data-item-name="user">
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
                                                                {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endsection