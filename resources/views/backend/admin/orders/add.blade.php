@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('orders') }}">Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Orders</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Orders</h6>

                        <form class="forms-sample" method="POST" action="{{ route('store.orders') }}">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Product Name <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select name="product_id" class="form-control" required>
                                        <option value="">Select Product</option>
                                        @forelse ($getProduct as $valueP)
                                            <option value="{{ $valueP->id }}" {{ old('product_id') == $valueP->id ? 'selected' : '' }}>
                                                {{ $valueP->title }}
                                            </option>
                                        @empty
                                            <option disabled>No products available</option>
                                        @endforelse
                                    </select>
                                    @error('product_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Colour Name <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    @forelse ($getColour as $valueC)
                                        <div class="form-check">
                                            <input type="checkbox" name="colour_id[]" value="{{ $valueC->id }}" class="form-check-input"
                                                {{ (is_array(old('colour_id')) && in_array($valueC->id, old('colour_id'))) ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $valueC->name }}</label>
                                        </div>
                                    @empty
                                        <p>No colors available</p>
                                    @endforelse
                                    @error('colour_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Qtys <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="qtys" min="1" required value="{{ old('qtys') }}">
                                    @error('qtys')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary me-2" onclick="this.disabled=true; this.form.submit();">
                                Submit
                            </button>
                            <a href="{{ route('orders') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
