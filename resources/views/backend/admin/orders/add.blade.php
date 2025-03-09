@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('orders') }}">Order</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Order</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Order</h6>

                        <form class="forms-sample" method="POST" action="{{ route('add.orders') }}">
                            
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Product Name <span
                                        style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <select name="product_id" class="form-control">
                                        <option value="">Select Product</option>
                                        @foreach ($getProduct as $valueP)
                                            <option value="{{ $valueP->id }}">{{ $valueP->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                             {{-- Colour Selection --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Colour Name<span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    @foreach ($getColour as $valueC)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="colour_id[]" class="form-check-input" value="{{ $valueC->id }}">
                                                {{ $valueC->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    @error('colour_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>



                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Qtys<span style="color: red;">*</span></label>
                                <div class="col-sm-9">

                                    <input type="text" class="form-control" name="qtys" value="">




                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('orders') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
