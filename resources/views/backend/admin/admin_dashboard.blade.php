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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />

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
            var title = $('#getTitle').val();
            var slug = convertToSlug(title);
            $('#getSlug').val(slug);
        });
    </script>

    <script type="text/javascript">
        $('#country').on('change', function() {
            var countryId = this.value;

            var url = "{{ url('get-states-record/') }}" + "/" + countryId;

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#state').html('<option value="">Select State Name</option>');
                    $.each(data, function(key, value) {
                        $('#state').append('<option value="' + value.id + '">' + value
                            .state_name + '<option>');
                    });
                }
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
                    var url = "{{ url('get-states') }}" + "/" + countryId;
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(data) {
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
                            }
                        },
                        error: function() {
                            alert('Error fetching states. Please try again.');
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
                    var url = "{{ url('get-cities/') }}" + "/" + stateId;
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(data) {
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
                            }
                        },
                        error: function() {
                            alert('Error fetching cities. Please try again.');
                        },
                    });
                }
            });
        });
    </script>

    <script type="text/javascript">
        $('.statusCheckbox').on('change', function() {
            var status = $(this).is(':checked') ? 1 : 0;
            var itemId = $(this).data('id');
            // alert(itemId);
            $.ajax({
                url: '{{ url('admin/colour/change_status') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: itemId,
                    status: status
                },
                success: function(response) {
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Error:' + xhr.status + '-' + xhr.statusText)
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Ensure the meta name matches
                }
            });

            var calendar = $('#calendar').fullCalendar({
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: '{{ url('admin/full_calendar') }}', // Route for fetching events
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    var title = prompt('Event Title:');
                    if (title) {
                        var startFormatted = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
                        var endFormatted = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

                        $.ajax({
                            url: "{{ url('admin/full_calendar/action') }}",
                            type: "POST",
                            data: {
                                title: title,
                                start: startFormatted,
                                end: endFormatted,
                                type: 'add'
                            },
                            success: function(data) {
                                calendar.fullCalendar('refetchEvents');
                                alert("Event Created Successfully");
                            },
                            error: function(xhr, status, error) {
                                // console.error("Error:", error);
                                alert("Failed to create event. Please try again.");
                            }
                        });
                    }
                },

                editable: true,
                eventResize: function(event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;

                    $.ajax({
                        url: "{{ url('admin/full_calendar/action') }}",
                        type: "POST",
                        data: {
                            title: title,
                            start: startFormatted,
                            end: endFormatted,
                            id: id,
                            type: 'update'
                        },
                        success: function(response) {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Updated Successfully");
                        },
                        error: function(xhr, status, error) {
                            // console.error("Error:", error);
                            alert("Failed to update event. Please try again.");
                        }
                    });
                },
                eventDrop: function(event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;

                    $.ajax({
                        url: "{{ url('admin/full_calendar/action') }}",
                        type: "POST",
                        data: {
                            title: title,
                            start: startFormatted,
                            end: endFormatted,
                            id: id,
                            type: 'update'
                        },
                        success: function(response) {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Updated Successfully");
                        },
                        error: function(xhr, status, error) {
                            // console.error("Error:", error);
                            alert("Failed to update event. Please try again.");
                        }
                    });
                },
                eventClick: function(event) {
                    if (confirm("Are you sure you want to remove it?")) {
                        var id = event.id;
                        $.ajax({
                            url: "{{ url('admin/full_calendar/action') }}",
                            type: "POST",
                            data: {
                                id: id,
                                type: "delete"
                            },
                            success: function(response) {
                                calendar.fullCalendar('refetchEvents');
                                alert("Event Deleted Successfully");
                            }
                        });
                    }
                }
            });
        });
    </script>
    <script type="text/javascript">
        var path = "{{ url('admin/users/typeahead_autocomplete') }}";

        $('#user_name').typeahead({
            source: function(query, process) {
                return $.get(path, {
                        query: query
                    })
                    .done(function(data) {
                        return process(data);
                    })
                    .fail(function(xhr, status, error) {
                        console.error("Error fetching data: ", error);
                        alert("Failed to load suggestions. Please try again.");
                    });
            }
        });
    </script>

    <script type="text/javascript">
        $('.ChangeSupportStatus').change(function() {
            var id = $(this).attr('id');
            var status = $(this).val();

            $.ajax({
                type: 'GET',
                url: "{{ url('admin/change_support_status') }}",
                data: {
                    id: id,
                    status: status
                },
                dataType: 'JSON',
                success: function(data) {
                    alert('Status Successfully Changed');
                }
            });
        });
    </script>


</body>

</html>
