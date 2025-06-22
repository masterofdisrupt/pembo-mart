@extends('layouts.app')

@section('style')
<style>
    .password-toggle {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 2;
    }
    .form-group {
        position: relative;
    }
    .strength-meter {
        height: 4px;
        background-color: #e9ecef;
        border-radius: 4px;
        margin-top: 4px;
        overflow: hidden;
    }
    .strength-meter-fill {
        height: 100%;
        transition: width 0.3s ease-in-out;
    }
</style>
@endsection

@section('content')
<main class="main">
    <div class="page-header text-center">
        <div class="container">
            <h1 class="page-title">Change Password</h1>
        </div>
    </div>

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <br>
                <div class="row">
                    @include('user._sidebar')

                    <div class="col-md-8 col-lg-9">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">

                                @if(session('success'))
                                    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
                                        <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
                                            <div class="d-flex">
                                                <div class="toast-body">
                                                    {{ session('success') }}
                                                </div>
                                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <script>
                                        document.addEventListener('DOMContentLoaded', () => {
                                            document.querySelector('.card-body')?.scrollIntoView({ behavior: 'smooth' });
                                        });
                                    </script>
                                @endif

                                <form action="{{ route('user.update.password') }}" method="POST" class="form-horizontal">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="current_password">Old Password *</label>
                                        <div class="form-group">
                                            <input type="password" name="current_password" id="current-password"
                                                class="form-control @error('current_password') is-invalid @enderror" required>
                                            <span class="password-toggle" onclick="togglePassword('current_password', this)">
                                                👁️
                                            </span>
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <label for="password">New Password *</label>
                                            <div class="form-group">
                                                <input type="password" name="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror" required>
                                                <span class="password-toggle" onclick="togglePassword('password', this)">
                                                    👁️
                                                </span>
                                                <div class="strength-meter">
                                                    <div class="strength-meter-fill bg-danger" id="passwordStrength" style="width: 0%;"></div>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label for="confirm_password">Confirm Password *</label>
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" id="confirm-password"
                                                    class="form-control @error('password_confirmation') is-invalid @enderror" required>
                                                <span class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                                                    👁️
                                                </span>
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-2">Update Password</button>
                                </form>
                            </div>
                        </div>
                    </div> <!-- col -->
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script type="text/javascript">
    // Show toast if exists
    document.addEventListener("DOMContentLoaded", function () {
        const toastEl = document.querySelector('.toast');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
            toast.show();
        }
    });

    // Toggle password visibility
    function togglePassword(fieldId, icon) {
        const input = document.getElementById(fieldId);
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "🙈";
        } else {
            input.type = "password";
            icon.textContent = "👁️";
        }
    }

    // Password strength meter
    document.getElementById('password').addEventListener('input', function () {
        const val = this.value;
        const meter = document.getElementById('passwordStrength');
        let strength = 0;

        if (val.length >= 8) strength += 1;
        if (/[A-Z]/.test(val)) strength += 1;
        if (/[0-9]/.test(val)) strength += 1;
        if (/[^A-Za-z0-9]/.test(val)) strength += 1;

        const strengthPercent = (strength / 4) * 100;
        meter.style.width = strengthPercent + '%';

        if (strengthPercent < 25) {
            meter.className = 'strength-meter-fill bg-danger';
        } else if (strengthPercent < 50) {
            meter.className = 'strength-meter-fill bg-warning';
        } else if (strengthPercent < 75) {
            meter.className = 'strength-meter-fill bg-info';
        } else {
            meter.className = 'strength-meter-fill bg-success';
        }
    });
</script>
@endsection
