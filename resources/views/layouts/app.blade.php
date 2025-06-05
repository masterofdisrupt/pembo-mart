<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ !empty($meta_title) ? $meta_title : '' }}</title>
    @if (!empty($meta_description))
        <meta name="description" content="{{ $meta_description }}">
    @endif
    @if (!empty($meta_keywords))
        <meta name="keywords" content="{{ $meta_keywords }}">
    @endif

    @php
        $getSystemSettingApp = App\Models\SystemSetting::getSingleRecord();
    @endphp
    <link rel="shortcut icon" href="{{ $getSystemSettingApp->getFavicon() }}">
   
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    @yield('style')
    <style type="text/css">
    .btn-wishlist-add::before {
        content: '\f233' !important;
    }
    </style>
</head>

<body>
    <div class="page-wrapper">

        @include('layouts._header')

        @yield('content')

        @include('layouts._footer')

     </div>
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div>
    <!-- End .mobil-menu-overlay -->

    @include('layouts._mobile_menu')

    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                                </li>
                            </ul>
                            
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                    <form action="{{ route('signin') }}" method="POST" id="signin-form">
                                        @csrf

                                        <input type="hidden" name="redirect_url" value="{{ url()->full() }}">
                                        <div class="form-group">
                                            <label for="singin-email">Email *</label>
                                            <input type="text" class="form-control" id="singin-email" name="email" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="singin-password">Password *</label>
                                            <input type="password" class="form-control" id="singin-password" name="password" required>
                                        </div>

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2" id="signin-submit">
                                                <span>LOG IN</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="is_remember" id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Remember Me</label>
                                            </div>

                                            <a href="{{ route('forgot.password') }}" class="forgot-link">Forgot Your Password?</a>
                                        </div>
                                    </form>
                                   
                                </div>
                                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                    <form action="{{ route('register') }}" id="register-form" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="register-name">Name <span style="color: red;"> *</span></label>
                                            <input type="text" class="form-control" id="register-name" name="name" required>
                                            <span class="invalid-feedback" id="error-name"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="register-middle-name">Middle Name <span style="color: red;"> *</span></label>
                                            <input type="text" class="form-control" id="register-middle-name" name="middle_name" required>
                                            <span class="invalid-feedback" id="error-middle_name"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="register-surname">Surname <span style="color: red;"> *</span></label>
                                            <input type="text" class="form-control" id="register-surname" name="surname" required>
                                            <span class="invalid-feedback" id="error-surname"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="register-email">Email <span style="color: red;"> *</span></label>
                                            <input type="email" class="form-control" id="register-email" name="email" required>
                                            <span class="invalid-feedback" id="error-email"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="register-password">Password <span style="color: red;">*</span></label>
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
                                            <button type="submit" class="btn btn-outline-primary-2" id="register-submit">
                                                <span>SIGN UP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="register-policy" required>
                                                <label class="custom-control-label" for="register-policy">I agree to the <a href="#">privacy policy</a> *</label>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row no-gutters bg-white newsletter-popup-content">
                    <div class="col-xl-3-5col col-lg-7 banner-content-wrap">
                        <div class="banner-content text-center">
                            <img src="assets/images/popup/newsletter/logo.png" class="logo" alt="logo" width="60" height="15">
                            <h2 class="banner-title">get <span>25<light>%</light></span> off</h2>
                            <p>Subscribe to the Molla eCommerce newsletter to receive timely updates from your favorite products.</p>
                            <form action="#">
                                <div class="input-group input-group-round">
                                    <input type="email" class="form-control form-control-white" placeholder="Your Email Address" aria-label="Email Adress" required>
                                    <div class="input-group-append">
                                        <button class="btn" type="submit"><span>go</span></button>
                                    </div>
                                </div>
                            </form>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                <label class="custom-control-label" for="register-policy-2">Do not show this popup again</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2-5col col-lg-5 ">
                        <img src="{{ url('assets/images/popup/newsletter/img-1.jpg') }}" class="newsletter-img" alt="newsletter">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    
    <!-- Plugins JS File -->
    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url('assets/js/superfish.min.js') }}"></script>
    <script src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ url('assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function () {

        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif


        // ========== Password Strength & Confirmation ==========
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

        if (passwordInput && confirmInput) {
            passwordInput.addEventListener('input', validatePassword);
            confirmInput.addEventListener('input', validateConfirmation);
        }

        // ========== Sign-In AJAX ==========
        $('#signin-form').on('submit', function (e) {
            e.preventDefault();

            const btn = $('#signin-submit');
            const originalText = btn.html();
            btn.prop('disabled', true).html('<span>Loading...</span>');

            $.ajax({
                type: 'POST',
                url: '{{ route('signin') }}',
                data: $(this).serialize(),
                success: function (response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        setTimeout(function () {
                            window.location.href = response.redirect_url;
                        }, 2000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON?.message || 'An unexpected error occurred.');
                },
                complete: function () {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });

        // ========== Register AJAX ==========
        $('#register-form').on('submit', function (e) {
            e.preventDefault();

            const btn = $('#register-submit');
            const originalText = btn.html();
            btn.prop('disabled', true).html('<span>Loading...</span>');

            $.ajax({
                type: 'POST',
                url: '{{ route('register') }}',
                data: $(this).serialize(),
                success: function (response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr) {
                    $('#register-form .form-control').removeClass('is-invalid');
                    $('#register-form .invalid-feedback').text('');

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (field, messages) {
                            const input = $('#register-form').find(`[name="${field}"]`);
                            input.addClass('is-invalid');
                            $(`#error-${field}`).text(messages[0]);
                        });
                    } else {
                        toastr.error(xhr.responseJSON.message || 'An unexpected error occurred.');
                    }
                },
                complete: function () {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });

        // ========== Wishlist Click ==========
        $('body').delegate('.add-to-wishlist', 'click', function (e) {
    e.preventDefault();
    const productId = $(this).data('id');

    $.ajax({
        type: 'POST',
        url: "{{ route('wishlist.add') }}",
        data: {
            product_id: productId,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            const $button = $(`.add-to-wishlist[data-id="${productId}"]`);
            $button.toggleClass('btn-wishlist-add');

            if (response.is_wishlist === 0) {
                toastr.error('Product removed from wishlist.');
            } else {
                toastr.success('Product added to wishlist.');
            }
        }
    });
});

    });
</script>

@yield('script')

</body>
</html>