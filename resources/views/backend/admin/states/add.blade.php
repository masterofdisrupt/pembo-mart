@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('states') }}">States</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add States</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add States</h6>

                        <form class="forms-sample" method="POST" action="{{ route('store.states') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="" class="col-sm-3 col-form-label">Countries Name<span
                                        style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="countries_id" required>
                                        <option value="">Select Countries Name</option>
                                        @foreach ($getCountries as $value)
                                            <option value="{{ $value->id }}">{{ $value->countries_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">States Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="states_name"
                                        placeholder="Enter State Name" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('states') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
