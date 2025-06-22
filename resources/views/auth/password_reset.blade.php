@extends('layouts.app')
@section('style')

@endsection

@section('content')

<main class="main">
    <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('{{ url('assets/images/backgrounds/login-bg.jpg') }}')">
        <div class="container">
            <div class="form-box">
            	<div class="form-tab">
	            	<ul class="nav nav-pills nav-fill" role="tablist">
						<li class="nav-item">
							<a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2" aria-selected="false">Reset Password</a>
						</li>
						
					</ul>
					<div class="tab-content">
						<div class="" style="display: block;">

							@include('_message')
							
							<form action="" method="POST">
                                @csrf
							    <div class="form-group" style="margin-top: 40px;">
							    	<label for="register-password">New Password <span style="color: red;">*</span></label>
							    	<input 
                                        type="password" 
                                        class="form-control" 
                                        id="register-password" 
                                        name="password" 
                                        required
                                        >
                                        <span class="invalid-feedback d-block" id="error-password"></span>
							    </div>

                                <div class="form-group">
							    	 <label for="register-password-confirmation">Confirm Password <span style="color: red;">*</span></label>
                                            <input 
                                                type="password" 
                                                class="form-control" 
                                                id="register-password-confirmation" 
                                                name="password_confirmation" 
                                                required
                                            >
                                            <span class="invalid-feedback d-block" id="error-password-confirmation"></span>
							    </div>

							    <div class="form-footer">
							    	<button type="submit" class="btn btn-outline-primary-2">
			                			<span>Reset</span>
			            				<i class="icon-long-arrow-right"></i>
                                    </button>
							    </div>
							</form>							    	
						</div>							    
					</div>
				</div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('script')

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById('register-password');
    const confirmInput = document.getElementById('register-password-confirmation');
    const errorPassword = document.getElementById('error-password');
    const errorConfirm = document.getElementById('error-password-confirmation');

    function validatePassword() {
        const password = passwordInput.value;
        const errors = [];

        if (!/[A-Z]/.test(password)) errors.push("One uppercase letter");
        if (!/[a-z]/.test(password)) errors.push("One lowercase letter");
        if (!/[0-9]/.test(password)) errors.push("One number");
        if (!/[^A-Za-z0-9]/.test(password)) errors.push("One special character");

        if (errors.length > 0) {
            errorPassword.innerHTML = "Password must include at least:<ul><li>" + errors.join("</li><li>") + "</li></ul>";
            passwordInput.classList.add("is-invalid");
        } else {
            errorPassword.innerHTML = "";
            passwordInput.classList.remove("is-invalid");
        }

        validateConfirmation();
    }

    function validateConfirmation() {
        if (confirmInput.value !== passwordInput.value || !confirmInput.value) {
            errorConfirm.textContent = "Passwords do not match.";
            confirmInput.classList.add("is-invalid");
        } else {
            errorConfirm.textContent = "";
            confirmInput.classList.remove("is-invalid");
        }
    }

    passwordInput.addEventListener('input', validatePassword);
    confirmInput.addEventListener('input', validateConfirmation);
});
    </script>
@endsection


