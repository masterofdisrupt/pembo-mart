@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add User</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add User</h6>

                        <form class="forms-sample" method="POST" action="{{ route('add.users.store') }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">First Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" placeholder="Enter First Name"
                                        required>
                                    @error('name')
                                        <div class="text-danger">
                                            {{ $message }}<br>
                                            Name can only contain letters and spaces.
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Middle Name </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="middle_name"
                                        placeholder="Enter Middle Name">
                                    @error('middle_name')
                                        <div class="text-danger">
                                            {{ $message }}<br>
                                            Middle Name can only contain letters and spaces.
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Surname</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="surname" placeholder="Enter Surname">
                                    @error('surname')
                                        <div class="text-danger">
                                            {{ $message }}<br>
                                            Surname can only contain letters and spaces.
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Username <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="username" placeholder="Username"
                                        required>
                                    @error('username')
                                        <div class="text-danger">
                                            {{ $message }}<br>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email<span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" autocomplete="off"
                                        placeholder="Email" value="{{ old('email') }}" onblur="duplicateEmail(this)"
                                        required>
                                    {{-- <span style="color: red;" class="duplicate_message">{{ $errors->first('email') }}</span> --}}
                                    @error('email')
                                        <div class="text-danger">
                                            {{ $message }}<br>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Photo</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="photo">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Phone</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="phone" placeholder="Phone number">
                                    @error('phone')
                                        <div class="text-danger">
                                            {{ $message }}<br>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Role<span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="agent">Agent</option>
                                        <option value="user">User</option>
                                    </select>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Status<span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>

                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ url('admin/users') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- @section('script')
    <script type="text/javascript">
        function duplicateEmail(element) {
            var email = $(element).val();
            // alert(email);
            $.ajax({
                type: "POST",
                url: "{{ url('checkemail') }}", //Create Route in admin route
                data: {
                    email: email,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(res) {
                    if (res.exists) {
                        $(".duplicate_message").html("That email is taken. Try another.");

                    } else {
                        $(".duplicate_message").html("");
                    }
                },
                error: function(jqXHR, exception) {

                }
            });
        }
    </script>
@endsection --}}
