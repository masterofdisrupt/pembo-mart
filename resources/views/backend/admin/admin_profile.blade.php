@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        @include('_message')

        <div class="row profile-body">
            <!-- Left wrapper start -->
            <div class="d-none d-md-block col-md-4 col-xl-3 left-wrapper">
                <div class="card rounded">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="card-title mb-0">About</h6>
                        </div>
                        <p>{{ Auth::user()->about }}</p>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Name:</label>
                            <p class="text-muted">{{ Auth::user()->name }}</p>
                        </div>

                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Middle Name:</label>
                            <p class="text-muted">{{ Auth::user()->middle_name }}</p>
                        </div>

                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Surname:</label>
                            <p class="text-muted">{{ Auth::user()->surname }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Username:</label>
                            <p class="text-muted">{{ Auth::user()->username }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
                            <p class="text-muted">{{ Auth::user()->phone }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Joined:</label>
                            <p class="text-muted">{{ date('d-m-Y', strtotime(Auth::user()->created_at)) }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Lives:</label>
                            <p class="text-muted">{{ Auth::user()->address }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                            <p class="text-muted">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Website:</label>
                            <p class="text-muted">{{ Auth::user()->website }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Left wrapper end -->

            <!-- Middle wrapper start -->
            <div class="col-md-8 col-xl-9 middle-wrapper">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Profile Update</h6>

                                <form class="forms-sample" action="{{ url('admin_profile/update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    {{ @csrf_field() }}

                                    <div class="mb-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter your name"
                                            name="name" value="{{ old('name', $getRecord->name) }}" required>
                                        @error('name')
                                            <div class="text-danger">
                                                {{ __('Name can only contain letters and spaces.') }}

                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" placeholder="Enter your Middle Name"
                                            name="middle_name" value="{{ old('name', $getRecord->middle_name) }}">
                                        @error('middle_name')
                                            <div class="text-danger">
                                                {{ __('Middle Name can only contain letters and spaces.') }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Surname</label>
                                        <input type="text" class="form-control" placeholder="Enter your Surname"
                                            name="surname" value="{{ old('surname', $getRecord->surname) }}">
                                        @error('surname')
                                            <div class="text-danger">
                                                {{ __('Surname can only contain letters and spaces.') }}

                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter your Username"
                                            name="username" value="{{ old('username', $getRecord->username) }}" required>
                                        @error('username')
                                            <div class="text-danger">
                                                {{ $message }}<br>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" placeholder="Enter your Email"
                                            name="email" value="{{ old('email', $getRecord->email) }}" required>
                                        @error('email')
                                            <div class="text-danger">
                                                {{ $message }}<br>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter your Phone Number"
                                            name="phone" value="{{ old('phone', $getRecord->phone) }}" required>
                                        @error('phone')
                                            <div class="text-danger">
                                                {{ $message }}<br>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control"
                                            placeholder="New password (if changing)" name="password">
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


                                    <div class="mb-3">
                                        <label class="form-label">Profile Image</label>
                                        <input type="file" class="form-control" name="photo">
                                        @if (!empty($getRecord->photo))
                                            <img src="{{ asset('public/backend/upload/profile/' . $getRecord->photo) }}"
                                                style="width: 10%; height: 10%;">
                                        @endif
                                        @error('photo')
                                            <div class="text-danger">
                                                {{ __('Only specific image formats allowed, jpeg,png,jpg,gif size <= 2MB.') }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" placeholder="Address" name="address"
                                            value="{{ old('address', $getRecord->address) }}">
                                        @error('address')
                                            <div class="text-danger">
                                                {{ $message }}<br>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">About</label>
                                        <textarea name="about" class="form-control" placeholder="About">{{ old('about', $getRecord->about) }}</textarea>
                                        @error('about')
                                            <div class="text-danger">
                                                {{ $message }}<br>

                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Website</label>
                                        <input type="text" class="form-control" placeholder="Website" name="website"
                                            value="{{ old('website', $getRecord->website) }}">
                                        @error('website')
                                            <div class="text-danger">
                                                {{ $message }}<br>
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <button class="btn btn-secondary">Cancel</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Middle wrapper end -->
        </div>
    </div>
@endsection
