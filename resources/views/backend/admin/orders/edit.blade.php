@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('orders') }}">Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Orders</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Edit Orders</h6>

                        <form class="forms-sample" method="POST" action="{{ route('update.orders', $getRecord->id) }}" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                            @csrf
                            @method('PUT')

                            <!-- Product Selection -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Product Name <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select name="product_id" class="form-control" required>
                                        <option value="">Select Product</option>
                                        @foreach ($getProduct as $valueP)
                                            <option value="{{ $valueP->id }}" {{ $getRecord->product_id == $valueP->id ? 'selected' : '' }}>
                                                {{ $valueP->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Colour Selection -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Colour Name<span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    @php
                                        $selectedColours = collect($getOrderDetail)->pluck('colour_id')->toArray();
                                    @endphp

                                    @foreach ($getColour as $valueC)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="colour_id[]" value="{{ $valueC->id }}" 
                                                {{ in_array($valueC->id, $selectedColours) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $valueC->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Quantity Field -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Qtys<span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="qtys" value="{{ $getRecord->qtys }}" required min="1">
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            <a href="{{ route('orders') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
