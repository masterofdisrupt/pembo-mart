@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update User</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Update User</h6>

                        <form class="forms-sample" method="POST"
                            action="{{ route('admin.users.edit.store', $getRecord->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" value="{{ $getRecord->name }}"
                                        placeholder="Name" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Middle Name <span
                                        style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="middle_name"
                                        value="{{ $getRecord->middle_name }}" placeholder="Enter Middle Name" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Surname <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="surname"
                                        value="{{ $getRecord->surname }}" placeholder=" Enter Surname" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Username <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="username"
                                        value="{{ $getRecord->username }}" placeholder="Enter Username" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" autocomplete="off"
                                        placeholder="Email" value="{{ $getRecord->email }}" readonly>
                                    <span style="color: red;">{{ $errors->first('email') }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Photo</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="photo">
                                    <img src="{{ $getRecord->getProfile() }}" alt=""
                                        style="height: 100px; width: 100px; margin-top: 5px;">

                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Phone</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="phone"
                                        value="{{ $getRecord->phone }}" placeholder="Enter Phone number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Role<span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="role" required>
                                        <option value="">Select Role</option>
                                        <option {{ $getRecord->role === 'admin' ? 'selected' : '' }} value="admin">Admin
                                        </option>
                                        <option {{ $getRecord->role === 'agent' ? 'selected' : '' }} value="agent">Agent
                                        </option>
                                        <option {{ $getRecord->role === 'user' ? 'selected' : '' }} value="user">User
                                        </option>
                                    </select>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Status<span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="status" required>
                                        <option value="">Select Status</option>
                                        <option {{ $getRecord->status === 'active' ? 'selected' : '' }} value="active">
                                            Active</option>
                                        <option {{ $getRecord->status === 'inactive' ? 'selected' : '' }} value="inactive">
                                            Inactive</option>
                                    </select>

                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
