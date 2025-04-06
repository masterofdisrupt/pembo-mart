<!-- filepath: /opt/lampp/htdocs/pembo-mart/resources/views/backend/admin/change_password.blade.php -->

@extends('backend.admin.admin_dashboard')
@section('admin')
<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Change Password</h4>

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('update.password') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" 
                                       name="current_password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       required>
                                @error('current_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" 
                                       name="new_password" 
                                       class="form-control @error('new_password') is-invalid @enderror" 
                                       required>
                                @error('new_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" 
                                       name="new_password_confirmation" 
                                       class="form-control" 
                                       required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Password</button>
                            <a href="{{ route('change.password') }}" class="btn btn-secondary">Reset</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection