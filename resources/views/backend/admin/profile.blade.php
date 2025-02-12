@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        @include('_message')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.my.profile') }}">Profile</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update Profile</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Update Profile</h6>

                        <form class="forms-sample" method="POST" action="{{ route('admin.my.profile.update') }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" value="{{ $getRecord->name }}"
                                        placeholder="Enter Name">
                                    @error('name')
                                        <div class="text-danger">
                                            {{ __('Name can only contain letters and spaces.') }}

                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Middle Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="middle_name"
                                        value="{{ $getRecord->middle_name }}" placeholder="Enter Middle Name">
                                    @error('middle_name')
                                        <div class="text-danger">
                                            {{ __('Middle Name can only contain letters and spaces.') }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Surname</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="surname"
                                        value="{{ $getRecord->surname }}" placeholder="Enter Surname">
                                    @error('surname')
                                        <div class="text-danger">
                                            {{ __('Surname can only contain letters and spaces.') }}

                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" autocomplete="off"
                                        placeholder="Email" value="{{ old('email', $getRecord->email) }}" required>
                                    @error('email')
                                        <div class="text-danger">
                                            {{ $message }}<br>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Profile Image</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="photo">
                                    @if (!@empty($getRecord->photo))
                                        <img src="{{ asset('public/backend/upload/profile/' . $getRecord->photo) }}"
                                            height="100px" width="100px">
                                    @endif
                                    @error('photo')
                                        <div class="text-danger">
                                            {{ __('Only specific image formats allowed, jpeg,png,jpg,gif size <= 2MB.') }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Password <span style="color: red;"></span></label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="password"
                                        placeholder="New password (if changing)">
                                    <small class="form-text text-muted">
                                        (Leave blank if you are not changing the password.)
                                    </small>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">
                                            {{ $errors->first('password') }} <br>
                                            Password must include at least:
                                            <ul>
                                                <li>One uppercase letter</li>
                                                <li>One lowercase letter</li>
                                                <li>One number</li>
                                                <li>One special character</li>
                                            </ul>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
