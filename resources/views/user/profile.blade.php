@extends('layouts.app')

@section('style')
@endsection

@section('content')

<main class="main">
    <div class="page-header text-center">
        <div class="container">
            <h1 class="page-title">Edit Profile</h1>
        </div>
    </div>

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <br>
                <div class="row">

                    @include('user._sidebar')

                    <div class="col-md-8 col-lg-9">
                        <div class="tab-content">

                            <form action="{{ route('user.update.profile') }}" method="POST" class="form-horizontal">
                                @csrf

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="first_name">First Name *</label>
                                        <input type="text" name="first_name" id="first_name" value="{{ $getRecord->name }}" class="form-control" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="last_name">Last Name *</label>
                                        <input type="text" name="last_name" id="last_name" value="{{ $getRecord->surname }}" class="form-control" required>
                                    </div>
                                </div>

                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="{{ $getRecord->email }}" class="form-control" readonly>

                                <label for="company_name">Company Name (Optional)</label>
                                <input type="text" name="company_name" id="company_name" value="{{ $getRecord->company_name }}" class="form-control">

                                <label for="country">Country *</label>
                                <input type="text" name="country" id="country" value="{{ $getRecord->country }}" class="form-control" required>

                                <label for="address_one">Street Address *</label>
                                <input type="text" name="address_one" id="address_one" value="{{ $getRecord->address }}" class="form-control" placeholder="House number and street name" required>

                                <input type="text" name="address_two" id="address_two" value="{{ $getRecord->address_two }}" class="form-control mt-2" placeholder="Apartment, suite, unit etc. (Optional)">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="city">Town / City *</label>
                                        <input type="text" name="city" id="city" value="{{ $getRecord->city }}" class="form-control" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="state">State *</label>
                                        <input type="text" name="state" id="state" value="{{ $getRecord->state }}" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="postcode">Postcode / ZIP *</label>
                                        <input type="text" name="postcode" id="postcode" value="{{ $getRecord->postcode }}" class="form-control" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="phone">Phone *</label>
                                        <input type="tel" name="phone" id="phone" value="{{ $getRecord->phone }}" class="form-control" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info mt-4">
                            <strong>Note:</strong> Please ensure all fields are filled out correctly before submitting.
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
 document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            toastr.success(@json(session('success')));
        @endif

        @foreach ($errors->all() as $error)
            toastr.error(@json($error));
        @endforeach
    });
    </script>
@endsection
