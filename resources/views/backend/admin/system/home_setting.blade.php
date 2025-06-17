@extends('backend.admin.admin_dashboard')
@section('admin')
    <div class="page-content">

         @include('_message')

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('brands') }}">Home Setting</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Home Setting</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">

                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Home Setting</h6>


                        <form class="forms-sample" method="POST" action="{{ route('update.home.setting') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="title" class="col-sm-3 col-form-label">
                                    Trendy Product Title<span class="text-danger">*</span>
                                </label>
                            
                                    <input type="text" 
                                        name="trendy_product_title"                            
                                        class="form-control @error('trendy_product_title') is-invalid @enderror"
                                        value="{{ old('trendy_product_title', $getRecord->trendy_product_title) }}"
                                        placeholder="Enter Trendy Product Title"
                                        required
                                        >
                                    @error('trendy_product_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <div class="mb-4">
                                <label for="shop_category_title" class="col-sm-3 col-form-label">
                                    Shop Category Title<span class="text-danger">*</span>
                                </label>
                            
                                    <input type="text" 
                                        name="shop_category_title"                            
                                        class="form-control @error('shop_category_titles') is-invalid @enderror"
                                        value="{{ old('shop_category_title', $getRecord->shop_category_title) }}"
                                        placeholder="Enter Shop Category Title"
                                        required
                                        >
                                    @error('shop_category_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                
                            </div>

                            <div class="mb-4">
                                <label for="title" class="col-sm-3 col-form-label">
                                    Recent Arrival Title<span class="text-danger">*</span>
                                </label>
                            
                                <input type="text" 
                                    name="recent_arrival_title"                            
                                    class="form-control @error('recent_arrival_title') is-invalid @enderror"
                                    value="{{ old('recent_arrival_title', $getRecord->recent_arrival_title) }}"
                                    placeholder="Enter Recent Arrival Title"
                                    required
                                    >
                                @error('recent_arrival_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="title" class="col-sm-3 col-form-label">
                                    Blog Title<span class="text-danger">*</span>
                                </label>
                            
                                <input type="text" 
                                    name="blog_title"                            
                                    class="form-control @error('blog_title') is-invalid @enderror"
                                    value="{{ old('blog_title', $getRecord->blog_title) }}"
                                    placeholder="Enter Blog Title"
                                    required
                                    >
                                @error('blog_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="title" class="col-sm-3 col-form-label">
                                    Payment Delivery Title<span class="text-danger"></span>
                                </label>
                            
                                <input type="text" 
                                    name="payment_delivery_title"                            
                                    class="form-control @error('payment_delivery_title') is-invalid @enderror"
                                    value="{{ old('payment_delivery_title', $getRecord->payment_delivery_title) }}"
                                    placeholder="Enter Payment Delivery Title"
                                    >
                                @error('payment_delivery_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="title" class="col-sm-3 col-form-label">
                                    Payment Delivery Description<span class="text-danger"></span>
                                </label>
                            
                                <input type="text" 
                                    name="payment_delivery_description"                            
                                    class="form-control @error('payment_delivery_description') is-invalid @enderror"
                                    value="{{ old('payment_delivery_description', $getRecord->payment_delivery_description) }}"
                                    placeholder="Enter Payment Delivery Description"
                                    >
                                @error('payment_delivery_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-4">
                                <label for="payment_delivery_image" class="col-sm-3 col-form-label">
                                    Payment Delivery Image  <span class="text-danger">*</span>
                                </label>
                            
                                <div class="input-group">
                                    <input type="file" 
                                           name="payment_delivery_image" 
                                           class="form-control"
                                           
                                    >
                                </div>
                                @if (!empty($getRecord->getPaymentImage()))
                                        <div class="mt-2">
                                            <img src="{{ $getRecord->getPaymentImage() }}" 
                                                class="img-fluid" 
                                                style="max-width: 200px;">
                                        </div>
                                @endif
                          
                            </div>

                            <hr>

                            <div class="mb-4">
                                <label for="title" class="col-sm-3 col-form-label">
                                    Return & Refund Title<span class="text-danger"></span>
                                </label>
                            
                                <input type="text" 
                                    name="refund_title"                            
                                    class="form-control @error('refund_title') is-invalid @enderror"
                                    value="{{ old('refund_title', $getRecord->refund_title) }}"
                                    placeholder="Enter Return & Refund Title"
                                    >
                                @error('refund_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="col-sm-3 col-form-label">
                                    Return & Refund Description<span class="text-danger"></span>
                                </label>
                            
                                <input type="text" 
                                    name="refund_description"                            
                                    class="form-control @error('refund_description') is-invalid @enderror"
                                    value="{{ old('refund_description', $getRecord->refund_description) }}"
                                    placeholder="Enter Return & Refund Description"
                                    >
                                @error('refund_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="refund_image" class="col-sm-3 col-form-label">
                                    Return & Refund Image  <span class="text-danger">*</span>
                                </label>
                            
                                <div class="input-group">
                                    <input type="file" 
                                           name="refund_image" 
                                           class="form-control"
                                           
                                    >
                                </div>
                                @if (!empty($getRecord->getRefundImage()))
                                        <div class="mt-2">
                                            <img src="{{ $getRecord->getRefundImage() }}" 
                                                class="img-fluid" 
                                                style="max-width: 200px;">
                                        </div>
                                @endif
                          
                            </div>


                            <hr>

                            <div class="mb-4">
                                <label for="title" class="col-sm-3 col-form-label">
                                    Support Title<span class="text-danger"></span>
                                </label>
                            
                                <input type="text" 
                                    name="support_title"                            
                                    class="form-control @error('support_title') is-invalid @enderror"
                                    value="{{ old('support_title', $getRecord->support_title) }}"
                                    placeholder="Enter Support Title"
                                    >
                                @error('support_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="col-sm-3 col-form-label">
                                    Support Description<span class="text-danger"></span>
                                </label>
                            
                                <input type="text" 
                                    name="support_description"                            
                                    class="form-control @error('support_description') is-invalid @enderror"
                                    value="{{ old('support_description', $getRecord->support_description) }}"
                                    placeholder="Enter Support Description"
                                    >
                                @error('support_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="support_image" class="col-sm-3 col-form-label">
                                    Support Image  <span class="text-danger"></span>
                                </label>
                            
                                <div class="input-group">
                                    <input type="file" 
                                           name="support_image" 
                                           class="form-control"
                                           
                                    >
                                </div>
                                @if (!empty($getRecord->getSupportImage()))
                                        <div class="mt-2">
                                            <img src="{{ $getRecord->getSupportImage() }}" 
                                                class="img-fluid" 
                                                style="max-width: 200px;">
                                        </div>
                                @endif
                          
                            </div>

                            <hr>

                            <div class="mb-4">
                                <label for="title" class="col-sm-3 col-form-label">
                                    Signup Title<span class="text-danger">*</span>
                                </label>
                            
                                <input type="text" 
                                    name="signup_title"                            
                                    class="form-control @error('signup_title') is-invalid @enderror"
                                    value="{{ old('signup_title', $getRecord->signup_title) }}"
                                    placeholder="Enter Signup Title"
                                    >
                                @error('signup_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="signup_description" class="col-sm-3 col-form-label">
                                    Signup Description<span class="text-danger">*</span>
                                </label>
                            
                                <input type="text" 
                                    name="signup_description"                            
                                    class="form-control @error('signup_description') is-invalid @enderror"
                                    value="{{ old('signup_description', $getRecord->signup_description) }}"
                                    placeholder="Enter Signup Description"
                                    >
                                @error('signup_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-4">
                                <label for="signup_image" class="col-sm-3 col-form-label">
                                    Signup Image <span class="text-danger">*</span>
                                </label>
                            
                                <div class="input-group">
                                    <input type="file"
                                            id="signup_image" 
                                           name="signup_image" 
                                           class="form-control"
                                           
                                    >
                                </div>
                                @if (!empty($getRecord->getSignupImage()))
                                        <div class="mt-2">
                                            <img id="signup_image_preview" src="{{ $getRecord->getSignupImage() }}" 
                                                class="img-fluid" 
                                                style="max-width: 200px;">
                                        </div>
                                @endif
                          
                            </div>
                                
                            <div class="text-end">
                                <a href="{{ route('home.setting') }}" class="btn btn-secondary me-2">
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

<script type="text/javascript">
document.getElementById('signup_image').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('signup_image_preview');

    if (!file) return;

    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    const maxSize = 2 * 1024 * 1024; // 2MB

    // File type check
    if (!validTypes.includes(file.type)) {
        alert('Please select a valid image file (JPG, PNG, or WEBP).');
        event.target.value = '';
        preview.src = '';
        return;
    }

    // File size check
    if (file.size > maxSize) {
        alert('Image must be less than 2MB.');
        event.target.value = '';
        preview.src = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        preview.src = e.target.result;
    };
    reader.readAsDataURL(file);
});
</script>
@endsection
