@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        @include('_message')

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Users List</li>
            </ol>

            <div class="d-flex align-items-center">
                <a href="javascript:void(0)" class="btn btn-info">
                    {{-- {{ $TotalAdmin }}  --}}
                    Admin
                </a>&nbsp;&nbsp;
                <a href="javascript:void(0)" class="btn btn-secondary">
                    {{-- {{ $TotalAgent }}  --}}
                    Agent
                </a>&nbsp;&nbsp;
                <a href="javascript:void(0)" class="btn btn-primary">
                    {{-- {{ $TotalUser }}  --}}
                    User
                </a>&nbsp;&nbsp;
                <a href="javascript:void(0)" class="btn btn-warning">
                    {{-- {{ $TotalActive }}  --}}
                    Active
                </a>&nbsp;&nbsp;
                <a href="javascript:void(0)" class="btn btn-danger">
                    {{-- {{ $TotalInActive }}  --}}
                    In Active
                </a>&nbsp;&nbsp;
                <a href="javascript:void(0)" class="btn btn-success">
                    {{-- {{ $Total }}  --}}
                    Total
                </a>
            </div>
        </nav>

        {{-- Search Box start --}}
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Search Users</h6>
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
                                        <label for="" class="form-label">Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control"
                                            value="{{ Request()->middle_name }}" placeholder="Enter Middle Name">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Surname</label>
                                        <input type="text" name="surname" class="form-control"
                                            value="{{ Request()->surname }}" placeholder="Enter Surname">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Username</label>
                                        <input type="text" name="username" value="{{ Request()->username }}"
                                            class="form-control" placeholder="Enter username">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email Id</label>
                                        <input type="text" name="email" value="{{ Request()->email }}"
                                            class="form-control" placeholder="Enter email id">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Phone Number</label>
                                        <input type="text" name="phone" value="{{ Request()->phone }}"
                                            class="form-control" placeholder="Enter phone number">
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
                                        <label class="form-label">Role</label>
                                        <select class="form-control" name="role">
                                            <option value="">Select role</option>
                                            <option value="admin" {{ Request()->role === 'admin' ? 'selected' : '' }}>
                                                Admin</option>
                                            <option value="agent" {{ Request()->role === 'agent' ? 'selected' : '' }}>
                                                Agent</option>
                                            <option value="user" {{ Request()->role === 'user' ? 'selected' : '' }}>User
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="">Select status</option>
                                            <option value="active" {{ Request()->status === 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive"
                                                {{ Request()->status === 'inactive' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
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
                                <a href="{{ url('admin/users') }}" class="btn btn-danger ms-2">Reset</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>

        {{-- Search Box end --}}

        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Name..." />

        <br>

        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h4 class="card-title">Users List</h4>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('admin.add.users') }}" class="btn btn-primary">
                                    Add User
                                </a>
                            </div>
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
                                        <form class="a_form{{ $value->id }}" method="POST">

                                            {{ csrf_field() }}

                                            <tr class="table-info text-dark">
                                                <td>{{ $value->id }}</td>
                                                <td style="min-width: 150px;">
                                                    <input type="hidden" name="edit_id" value="{{ $value->id }}">
                                                    <input type="text" class="form-control" name="edit_name"
                                                        value="{{ old('name', $value->name) }}">
                                                    <br>
                                                    <button type="button" class="btn btn-success submitform"
                                                        id="{{ $value->id }}">Save</button>
                                                </td>
                                                <td>{{ $value->middle_name }}</td>
                                                <td>{{ $value->surname }}</td>
                                                <td>{{ $value->username }}</td>
                                                <td>{{ $value->email }}</td>
                                                <td>
                                                    @if (!empty($value->getProfile()))
                                                        <a href="{{ $value->getProfile() }}" data-lightbox="example-set">
                                                            <img src="{{ $value->getProfile() }}"
                                                                style="width: 100%; height: 100%;">
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
                                                    <select name="" class="form-control changeStatus"
                                                        id="{{ $value->id }}" style="width: 170px;">
                                                        <option {{ $value->status === 'active' ? 'selected' : '' }}
                                                            value="active">Active</option>
                                                        <option {{ $value->status === 'inactive' ? 'selected' : '' }}
                                                            value="inactive">In Active</option>
                                                    </select>
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                                <td>
                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ route('admin.users.view', $value->id) }}"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-eye icon-sm me-2">
                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg> <span class="">View</span></a>

                                                    <a class="dropdown-item d-flex align-items-center"
                                                        href="{{ route('admin.users.edit', $value->id) }}"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-edit-2 icon-sm me-2">
                                                            <path
                                                                d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                            </path>
                                                        </svg> <span class="">Edit</span></a>

                                                    <a id="delete-form-{{ $value->id }}"
                                                        class="dropdown-item d-flex align-items-center"
                                                        href="{{ url('admin/users/delete/' . $value->id) }}"
                                                        onclick="confirmDelete({{ $value->id }})"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-trash icon-sm me-2">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path
                                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                            </path>
                                                        </svg> <span class="">Delete</span></a>

                                                </td>

                                            </tr>
                                        </form>
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

@section('script')
    <script type="text/javascript">
        $('table').delegate('.submitform', 'click', function() {
            var id = $(this).attr('id');
            // alert(id);
            $.ajax({

                url: "{{ url('admin/users/update') }}",
                method: "POST",
                data: $('.a_form' + id).serialize(),
                dataType: 'json',
                success: function(response) {
                    alert(response.success);
                }
            });
        });

        $('.changeStatus').change(function() {
            var status_id = $(this).val();
            var order_id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: "{{ url('admin/users/changeStatus') }}",
                data: {
                    status_id: status_id,
                    order_id: order_id
                },
                dataType: 'json',
                success: function(data) {
                    alert('Status Successfully Changed');
                    window.location.href = "";
                }
            });
        });
    </script>
    <script type="text/javascript">
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                document.getElementById("delete-form-" + id).submit();
            }
        }
    </script>
@endsection
