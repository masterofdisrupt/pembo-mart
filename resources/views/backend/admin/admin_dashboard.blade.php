<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="author" content="NobleUI">
    <meta name="keywords"
        content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>PEMBO | MART</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('public/assets/vendors/core/core.css') }}">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('public/assets/vendors/flatpickr/flatpickr.min.css') }}">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('public/assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/demo2/style.css') }}">
    <!-- End layout styles -->

    <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tinymce@7.2.1/skins/ui/oxide/content.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    

    @yield('style')

</head>

<body>
    <div class="main-wrapper">

        <!-- partial:partials/_sidebar.html -->
        @include('backend.admin.body.sidebar')

        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->
            @include('backend.admin.body.header')
            <!-- partial -->

            @yield('admin')

            <!-- partial:partials/_footer.html -->
            @include('backend.admin.body.footer')
            <!-- partial -->

        </div>
    </div>

    <!-- core:js -->
    <script src="{{ asset('public/assets/vendors/core/core.js') }}"></script>
    <!-- endinject -->

    <!-- Plugin js for this page -->
    <script src="{{ asset('public/assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('public/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <!-- End plugin js for this page -->

    <!-- inject:js -->
    <script src="{{ asset('public/assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/template.js') }}"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <script src="{{ asset('public/assets/js/dashboard-dark.js') }}"></script>
    <!-- End custom js for this page -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/9000.0.1/prism.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.2.1/tinymce.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>

    @yield('script')

    <script type="text/javascript">
        $('.delete-all-option').change(function() {
            var total = '';
            $('.delete-all-option').each(function() {
                if (this.checked) {
                    var id = $(this).val();
                    total += id + ',';
                }
            });
            var url = '{{ url('admin/support/delete_multi_item?id=') }}' + total;
            $('#getDeleteUrl').attr('href', url);
        });
    </script>
    <script type="text/javascript">
        tinymce.init({
            selector: '.editor',
            height: '500px',
            plugins: 'link code image textcolor codesample',
            codesample_languages: [{
                text: 'HTML/XML',
                value: 'markup'
            }, {
                text: 'Javascript',
                value: 'javascript'
            }, {
                text: 'CSS',
                value: 'css'
            }, {
                text: 'PHP',
                value: 'php'
            }, {
                text: 'Ruby',
                value: 'ruby'
            }, {
                text: 'Python',
                value: 'python'
            }, {
                text: 'Java',
                value: 'java'
            }, {
                text: 'C',
                value: 'c'
            }, {
                text: 'C#',
                value: 'csharp'
            }, {
                text: 'C++',
                value: 'cpp'
            }],
            toolbar: [
                "fontselect | bullist numlist outdent indent | undo redo | fontsizeselect | styleselect | bold italic | link image",
                "codesample",
                "alignleft aligncenter alignright justify | forecolor backcolor", "fullscreen"
            ],
            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
            font_formats: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutikndPadmini=Akpdmi-n',
            content_style: 'body { color: white; }',
        });

        function convertToSlug(Text) {
            return Text.toLowerCase()
                .replace(/ /g, "-")
                .replace(/[^\w-]+/g, "");
        }

        $('body').delegate('#ConvertSlug', 'click', function() {
            var name = $('#getName').val();
            var slug = convertToSlug(name);
            $('#getSlug').val(slug);
        });
    </script>

  <script type="text/javascript">
    $(document).ready(function() {
        $('#country').on('change', function() {
            var countryId = this.value;
            var url = "{{ route('get.state.name', ':countryId') }}";
                url = url.replace(':countryId', countryId);
            // Disable state dropdown & show loading indicator
            $('#state').html('<option value="">Loading...</option>').prop('disabled', true);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#state').html('<option value="">Select State Name</option>');
                    
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            $('#state').append('<option value="' + value.id + '">' + value.state_name + '</option>');
                        });
                        $('#state').prop('disabled', false);
                    } else {
                        $('#state').html('<option value="">No states available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    alert("Failed to fetch states. Please try again.");
                    $('#state').html('<option value="">Select State Name</option>').prop('disabled', true);
                }
            });
        });
    });
</script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#country_add').on('change', function() {
            var countryId = this.value;

            // Reset state and city dropdowns
            $('#state_add').html('<option value="">Select State</option>');
            $('#city_add').html('<option value="">Select City</option>');

            // Fetch states based on selected country
            if (countryId) {
                var url = "{{ route('get.state.name', ':countryId') }}";
                url = url.replace(':countryId', countryId);

                // Disable state dropdown & show loading indicator
                $('#state_add').html('<option value="">Loading...</option>').prop('disabled', true);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#state_add').html('<option value="">Select State</option>');
                        if (data && data.length > 0) {
                            $('#state_add').append(
                                data.map(function(state) {
                                    return (
                                        '<option value="' +
                                        state.id +
                                        '">' +
                                        state.state_name +
                                        '</option>'
                                    );
                                }).join('')
                            );
                        } else {
                            $('#state_add').html('<option value="">No states available</option>');
                        }
                        $('#state_add').prop('disabled', false);
                    },
                    error: function() {
                        alert('Error fetching states. Please try again.');
                        $('#state_add').html('<option value="">Select State</option>').prop('disabled', false);
                    },
                });
            }
        });

        $('#state_add').on('change', function() {
            var stateId = this.value;

            // Reset city dropdown
            $('#city_add').html('<option value="">Select City</option>');

            // Fetch cities based on selected state
            if (stateId) {
                var url = "{{ route('get.cities', ':stateId') }}";
                url = url.replace(':stateId', stateId);

                // Disable city dropdown & show loading indicator
                $('#city_add').html('<option value="">Loading...</option>').prop('disabled', true);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#city_add').html('<option value="">Select City</option>');
                        if (data && data.length > 0) {
                            $('#city_add').append(
                                data.map(function(city) {
                                    return (
                                        '<option value="' +
                                        city.id +
                                        '">' +
                                        city.city_name +
                                        '</option>'
                                    );
                                }).join('')
                            );
                        } else {
                            $('#city_add').html('<option value="">No cities available</option>');
                        }
                        $('#city_add').prop('disabled', false);
                    },
                    error: function() {
                        alert('Error fetching cities. Please try again.');
                        $('#city_add').html('<option value="">Select City</option>').prop('disabled', false);
                    },
                });
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('change', '.statusCheckbox', function() {
            var status = $(this).is(':checked') ? 1 : 0;
            var itemId = $(this).data('id');

            $.ajax({
                url: '{{ route('colour.change_status') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: itemId,
                    status: status
                },
                success: function(response) {
                    alert(response.message);
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + xhr.status + ' - ' + xhr.statusText + '\n' + error);
                }
            });
        });
    });
</script>



<style>
.loading {
    background-image: url('{{ asset("public/assets/images/loading.gif") }}');
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 20px;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
    // Handle delete button clicks
    $('.btn-delete').click(function(e) {
        e.preventDefault();
        const form = $(this).closest("form"); // More reliable than parents()
        const itemName = $(this).data('item-name') || 'item'; // Allow custom item names
        
        Swal.fire({
            title: "Delete Confirmation",
            text: `Are you sure you want to delete this ${itemName}?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545", // Bootstrap danger color
            cancelButtonColor: "#6c757d", // Bootstrap secondary color
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            reverseButtons: true,
            focusCancel: true // Focus on cancel button by default
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Deleting...',
                    html: 'Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                form.submit();
            }
        });
    });
});
</script>




</body>

</html>
