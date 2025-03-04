@extends('backend.admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        @include('_message')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('smtp') }}">SMTP Setting</a></li>
                <li class="breadcrumb-item active" aria-current="page">SMTP Setting</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">SMTP Setting Update</h6>

                        <form class="forms-sample" method="POST" action="{{ route('smtp.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')  {{-- Ensure proper HTTP method usage --}}

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">App Name <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="app_name" placeholder="Enter App Name"
                                        value="{{ old('app_name', $getRecord->app_name) }}" required>
                                    @error('app_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Mail Mailer <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mail_mailer" placeholder="Enter Mail Mailer"
                                        value="{{ old('mail_mailer', $getRecord->mail_mailer) }}" required>
                                    @error('mail_mailer')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Mail Host <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mail_host" placeholder="Enter Mail Host"
                                        value="{{ old('mail_host', $getRecord->mail_host) }}" required>
                                    @error('mail_host')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Mail Port <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="mail_port" placeholder="Enter Mail Port"
                                        value="{{ old('mail_port', $getRecord->mail_port) }}" required>
                                    @error('mail_port')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Mail Username <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mail_username" placeholder="Enter Mail Username"
                                        value="{{ old('mail_username', $getRecord->mail_username) }}" required>
                                    @error('mail_username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Mail Password <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="mail_password" placeholder="Enter Mail Password">
                                    <small class="form-text text-muted">
                                        Leave blank if you are not changing the password.
                                    </small>
                                    @error('mail_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Mail Encryption <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="mail_encryption" required>
                                        <option value="tls" {{ $getRecord->mail_encryption == 'tls' ? 'selected' : '' }}>TLS</option>
                                        <option value="ssl" {{ $getRecord->mail_encryption == 'ssl' ? 'selected' : '' }}>SSL</option>
                                        <option value="null" {{ $getRecord->mail_encryption == 'null' ? 'selected' : '' }}>None</option>
                                    </select>
                                    @error('mail_encryption')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Mail From Address <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="mail_from_address" placeholder="Enter Mail From Address"
                                        value="{{ old('mail_from_address', $getRecord->mail_from_address) }}" required>
                                    @error('mail_from_address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Update SMTP</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
