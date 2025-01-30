@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Users View</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">View User</h6>

                        <form class="forms-sample">
                            <div class="row mb-3">
                                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">ID</label>
                                <div class="col-sm-9">
                                    {{ $getRecord->id }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">First Name</label>
                                <div class="col-sm-9">
                                    {{ $getRecord->name }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Middle Name</label>
                                <div class="col-sm-9">
                                    {{ $getRecord->middle_name }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Surname</label>
                                <div class="col-sm-9">
                                    {{ $getRecord->surname }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    {{ $getRecord->username }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    {{ $getRecord->email }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Photo</label>
                                <div class="col-sm-9">
                                    @if (!empty($getRecord->photo))
                                        <img src="{{ asset('public/backend/upload/profile/' . $getRecord->photo) }}"
                                            style="width: 10%; height: 100%;">
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Phone</label>
                                <div class="col-sm-9">
                                    {{ $getRecord->phone }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Website</label>
                                <div class="col-sm-9">
                                    {{ $getRecord->website }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-9">
                                    {{ $getRecord->address }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">About</label>
                                <div class="col-sm-9">
                                    {{ $getRecord->about }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Role</label>
                                <div class="col-sm-9">
                                    @if ($getRecord->role === 'admin')
                                        <span class="badge bg-info">Admin</span>
                                    @elseif ($getRecord->role === 'agent')
                                        <span class="badge bg-primary">Agent</span>
                                    @elseif ($getRecord->role === 'user')
                                        <span class="badge bg-success">User</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    @if ($getRecord->status === 'active')
                                        <span class="badge bg-primary">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Created At</label>
                                <div class="col-sm-9">
                                    {{ date('d-m-Y', strtotime($getRecord->created_at)) }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Updated At</label>
                                <div class="col-sm-9">
                                    {{ date('d-m-Y', strtotime($getRecord->updated_at)) }}
                                </div>
                            </div>

                            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
