@extends('backend.admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('cities') }}">City</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit City</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit City</h6>

                        <form class="forms-sample" method="POST" action="{{ route('update.cities', $getRecord->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Country Dropdown -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Country Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select name="country_id" class="form-control" id="country" required>
                                        <option value="">Select Country Name</option>
                                        @foreach ($getCountries as $value)
                                            <option {{ $value->id == $getRecord->country_id ? 'selected' : '' }}
                                                value="{{ $value->id }}">{{ $value->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- State Dropdown -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">State Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select name="state_id" class="form-control" id="state" required>
                                        <option value="">Select State Name</option>
                                        @foreach ($getStateRecord as $valueS)
                                            <option {{ $valueS->id == $getRecord->state_id ? 'selected' : '' }}
                                                value="{{ $valueS->id }}">{{ $valueS->state_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- City Name Input -->
                            <div class="row mb-3">
                                <label for="city_name" class="col-sm-3 col-form-label">City Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="city_name" class="form-control"
                                        placeholder="Enter City Name" value="{{ $getRecord->city_name }}" required>
                                </div>
                            </div>

                            <!-- Submit & Back Buttons -->
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            <a href="{{ route('cities') }}" class="btn btn-secondary">Back</a>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
