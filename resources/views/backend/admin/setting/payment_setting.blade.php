@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">

         @include('_message')

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('payment.setting') }}">Payment Setting</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Payment Setting</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">

                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Payment Setting</h6>


                        <form class="forms-sample" method="POST" action="{{ route('update.payment.setting') }}">
                            @csrf

                            <div class="mb-4 form-check">
                                <input type="checkbox" 
                                    id="is_cash"
                                    name="is_cash"                            
                                    class="form-check-input @error('is_cash') is-invalid @enderror"
                                    {{ old('is_cash', optional($getRecord)->is_cash) ? 'checked' : '' }}
                                >
                                <label for="is_cash" class="form-check-label">
                                    Cash On Delivery (On/Off)<span class="text-danger"></span>
                                </label>
                                @error('is_cash')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <div class="mb-4 form-check">
                                <input type="checkbox" 
                                    id="is_wallet"
                                    name="is_wallet"                            
                                    class="form-check-input @error('is_wallet') is-invalid @enderror"
                                    {{ old('is_wallet', optional($getRecord)->is_wallet) ? 'checked' : '' }}
                                >
                                <label for="is_wallet" class="form-check-label">
                                    Wallet (On/Off)<span class="text-danger"></span>
                                </label>
                                @error('is_wallet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                                                           
                            <div class="text-end">
                                <a href="{{ route('payment.setting') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Home Setting
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')

@endsection
