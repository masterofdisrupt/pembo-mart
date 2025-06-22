@extends('backend.admin.admin_dashboard')

@section('admin')
<div class="page-content">

        @include('_message')

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('product') }}">Product</a></li>
            <li class="breadcrumb-item active">Edit Product</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Edit Product</h6>

                    <form method="POST" action="{{ route('product.update', $product->id) }}" class="forms-sample" 
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ROW 1: Title, Category, Brand --}}
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" value="{{ old('title', $product->title) }}" required>
                                @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Category <span class="text-danger">*</span></label>
                                <select id="category_id" class="form-control" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach ($getCategory as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Brand <span class="text-danger"></span></label>
                                <select class="form-control" name="brand_id">
                                    <option value="">Select Brand</option>
                                    @foreach ($getBrand as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- ROW 2: SKU, Subcategory, Colours --}}
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>SKU <span class="text-danger"></span></label>
                                <input type="text" class="form-control" name="sku" value="{{ old('sku', $product->sku) }}">
                                @error('sku')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Sub Category <span class="text-danger"></span></label>
                                <select id="sub_category_id" class="form-control" name="sub_category_id">
                                    <option value="">Select Sub Category</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" {{ old('sub_category_id', $product->sub_category_id) == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                        
                                    @endforeach
                                </select>
                                @error('sub_category_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Colour <span class="text-danger"></span></label>
                                <div class="row">
                                  @if (!empty($getColour) && is_iterable($getColour))
                                    @foreach ($getColour as $colour)
                                        @php
                                            $isChecked = false;
                                            if (!empty($product->getColours)) {
                                                foreach ($product->getColours as $productColour) {
                                                    if ($productColour->colour_id == $colour->id) {
                                                        $isChecked = true;
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp

                                        @if (!empty($product->getColours))
                                            @foreach ($product->getColours as $productColour)
                                                @if ($productColour->colour_id == $colour->id)
                                                    <input type="hidden" name="old_colour_id[]" value="{{ $colour->id }}">
                                                @endif
                                            @endforeach
                                        @endif

                                        <div class="col-6 col-sm-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="colour_id[]" value="{{ $colour->id }}" id="colour{{ $colour->id }}" {{ $isChecked ? 'checked' : '' }}>
                                                <label class="form-check-label" for="colour{{ $colour->id }}">{{ $colour->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                </div>
                                @error('colour_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- ROW 3: Price + Old Price --}}
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label>Trendy Products <span class="text-danger"></span></label>
                                <div class="row">
                                    <div class="col-6 col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_trendy" {{ !empty($product->is_trendy) && $product->is_trendy == 1 ? 'checked' : '' }} id="is_trendy">
                                            <label class="form-check-label" for="is_trendy"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4 mb-3">
                                <label>Price (₦) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="price" value="{{ !empty($product->price) ? $product->price : '' }}" step="0.01" required>
                                @error('price')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Old Price (₦) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="old_price" value="{{ !empty($product->old_price) ? $product->old_price : '' }}" step="0.01" required>
                                @error('old_price')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- SIZE TABLE --}}

                            <div class="mb-4">
                                <label class="form-label fw-bold">Product Sizes <span class="text-danger">*</span></label>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Size Name</th>
                                                <th>Price (₦)</th>
                                                <th style="width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="size-rows">
                                            @php $i = $product->productSizes->count() ?? 0; @endphp
                                            @if (!empty($product->productSizes))
                                                @foreach ($product->productSizes as $size)                    
                                                    <tr id="delete-row{{ $i }}" class="align-middle">
                                                        <input type="hidden" name="size[{{ $i }}][id]" value="{{ $size->id }}">
                                                        <td>
                                                            <input type="text" 
                                                                class="form-control" 
                                                                value="{{ $size->name }}" 
                                                                name="size[{{ $i }}][name]" 
                                                                value="{{ $size->name }}" 
                                                                data-id="{{ $size->id }}"
                                                                placeholder="Enter Size Name"
                                                                required
                                                                pattern="[A-Za-z0-9\s\-]+"
                                                                title="Only letters, numbers, spaces and hyphens allowed">
                                                        </td>
                                                        <td>
                                                            <input type="number" 
                                                                class="form-control" 
                                                                value="{{ number_format($size->price, 2, '.', '') }}" 
                                                                name="size[{{ $i }}][price]" 
                                                                placeholder="0.00" 
                                                                step="0.01"
                                                                min="0"
                                                                required>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" 
                                                                    class="btn btn-danger btn-sm delete-row" 
                                                                    data-row="delete-row{{ $i }}"
                                                                    title="Delete Size">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                @endforeach
                                            @endif
                                            
                                            <tr class="align-middle" id="new-size-row">
                                                <td>
                                                    <input type="text" 
                                                        class="form-control" 
                                                        name="size[new][name]" 
                                                        placeholder="Enter Size Name"
                                                        pattern="[A-Za-z0-9\s\-]+"
                                                        title="Only letters, numbers, spaces and hyphens allowed">
                                                </td>
                                                <td>
                                                    <input type="number" 
                                                        class="form-control" 
                                                        name="size[new][price]" 
                                                        placeholder="0.00" 
                                                        step="0.01"
                                                        min="0">
                                                </td>
                                                <td>
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm add-row"
                                                            title="Add Size">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <small class="text-muted">Maximum 10 sizes allowed</small>
                                @error('size')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                      
                        {{-- IMAGE --}}
                        <div class="mb-4">
                            <label class="form-label">Product Images <span class="text-muted">(Max 5 images, 2MB each)</span></label>
                                <input type="file" 
                                    class="form-control" 
                                    name="image[]" 
                                    multiple 
                                    accept="image/jpeg,image/png,image/jpg"
                                    data-max-files="5"
                                    data-max-size="2048"
                                    >
                            <div class="invalid-feedback">
                                Please select valid image files (JPG, JPEG, PNG) less than 2MB each.
                            </div>
                            @error('image')<span class="text-danger">{{ $message }}</span>@enderror 

                             {{-- Show existing images --}}
                            @if($product->getImages->count())
                            <div class="mt-3" id="sortable">
                                <label class="form-label">Current Images</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($product->getImages as $image)
                                    @if(!empty($image->getProductImages()))
                                    <div class="position-relative sortable-image" id="image-{{ $image->id }}">
                                            <img src="{{ $image->getProductImages() ?? url('public/backend/upload/no-product-image.png') }}" 
                                                class="img-thumbnail" 
                                                style="height: 100px; width: 100px; object-fit: cover;">
                                            <button type="button" 
                                                    class="btn-sm position-absolute top-0 end-0 btn-delete-image" 
                                                    data-id="{{ $image->id }}"
                                                    style="border: none; background: none; cursor: pointer;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash icon-sm me-2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- DESCRIPTIONS --}}
                        <div class="mb-4">
                            <label>Short Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="short_description" rows="3" required>{{ old('short_description', $product->short_description) }}</textarea>
                            @error('short_description')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label>Description <span class="text-danger">*</span></label>
                            <textarea class="form-control editor" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                            @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label>Additional Information <span class="text-danger"></span></label>
                            <textarea class="form-control editor" name="additional_info" rows="4">{{ old('additional_info', $product->additional_info) }}</textarea>
                            @error('additional_info')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label>Shipping & Returns <span class="text-danger">*</span></label>
                            <textarea class="form-control editor" name="ship_and_returns" rows="4">{{ old('ship_and_returns', $product->ship_and_returns) }}</textarea>
                            @error('ship_and_returns')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        {{-- STATUS --}}
                        <div class="mb-4">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" required>
                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('product') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ url('public/assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ url('public/assets/js/jquery-ui.js') }}"></script>
<script src="{{ url('public/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ url('public/assets/js/axios.min.js') }}"></script>
<script src="{{ url('public/js/tinymce/tinymce.js') }}" referrerpolicy="origin"></script>
<script src="{{ url('public/js/tinymce/tinymce-jquery.min.js') }}" referrerpolicy="origin"></script>



<script type="text/javascript">

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.btn-delete-image').forEach(button => {
        button.addEventListener('click', function () {
            const imageId = this.getAttribute('data-id');
            if (!confirm('Are you sure you want to delete this image?')) return;

            const baseUrl = '{{ url('/') }}'; 
            axios.delete(`${baseUrl}/admin/product/image/${imageId}`
            )
            .then(response => {
                if (response.data.success) {
                    const imageElement = document.getElementById(`image-${imageId}`);
                    if (imageElement) imageElement.remove();
                    toastr.success('Image deleted successfully');
                } else {
                    toastr.error(response.data.message || 'Failed to delete image');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error(error.response?.data?.message || 'Failed to delete image');
            });
        });
    });

     $(document).ready(function () {
        $('#sortable').sortable({
            items: '.sortable-image',
            placeholder: 'ui-state-highlight',
            update: function (event, ui) {
                
                const sortedIDs = $(this).sortable('toArray');
                console.log('Sorted IDs:', sortedIDs);
               
                const baseUrl = '{{ url('/') }}'; 
                axios.post(`${baseUrl}/admin/product_image_sort`, { sortedIDs })
                    .then(response => {
                        console.log('Order updated successfully');
                    })
                    .catch(error => {
                        console.error('Error updating order:', error);
                    }); 
            }
        });

let i = {{ $i + 1 }};
const maxRows = 10;

$('body').on('click', '.add-row', function () {
    const lastRow = $('#new-size-row');
    const nameInput = lastRow.find('input[name*="[name]"]');
    const priceInput = lastRow.find('input[name*="[price]"]');

    if (!nameInput.val() || !priceInput.val()) {
        toastr.error('Please fill in both size name and price');
        return;
    }

    if (!nameInput[0].checkValidity()) {
        toastr.error('Invalid size name format');
        return;
    }

    const currentRows = $('#size-rows tr').length - 1; // exclude the new-size-row
    if (currentRows >= maxRows) {
        toastr.error(`Maximum ${maxRows} sizes allowed`);
        return;
    }

    const existingId = nameInput.data('id') || ''; 
    const hiddenIdInput = existingId 
        ? `<input type="hidden" name="size[${i}][id]" value="${existingId}">` 
        : '';

    const newRow = `<tr id="delete-row${i}" class="align-middle">
        <td>
            ${hiddenIdInput}
            <input type="text" 
                   class="form-control" 
                   name="size[${i}][name]" 
                   value="${nameInput.val()}"
                   required
                   pattern="[A-Za-z0-9\\s\\-]+"
                   title="Only letters, numbers, spaces and hyphens allowed">
        </td>
        <td>
            <input type="number" 
                   class="form-control" 
                   name="size[${i}][price]" 
                   value="${priceInput.val()}"
                   step="0.01"
                   min="0"
                   required>
        </td>
        <td>
            <button type="button" 
                    class="btn btn-danger btn-sm delete-row" 
                    data-row="delete-row${i}"
                    title="Delete Size">
                <i class="fas fa-trash-alt"></i>
            </button>
        </td>
    </tr>`;

    $(newRow).insertBefore('#new-size-row');

    nameInput.val('');
    priceInput.val('');

    i++;
});

// Remove dynamic row
$('body').on('click', '.delete-row', function () {
    $(this).closest('tr').remove();
});

// Prevent empty new-size-row from being submitted
$('form').on('submit', function () {
    const newRow = $('#new-size-row');
    const name = newRow.find('input[name*="[name]"]').val();
    const price = newRow.find('input[name*="[price]"]').val();

    if (!name && !price) {
        newRow.remove();
    }
});

$('#category_id').on('change', function () {
            var categoryID = $(this).val();
            if (categoryID) {
                $.ajax({
                    url: '{{ route("get.sub.categories") }}',
                    type: "POST",
                    data: {
                        category_id: categoryID,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: "json",
                    success: function (data) {
                        $('#sub_category_id').html(data.html);
                    }
                });
            } else {
                
                $('#sub_category_id').empty().append('<option value="">Select Sub Category</option>');
            }
        });
   
    
    });


    $('.editor').tinymce({
        height: 500,
        menubar: false,
        plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | bold italic backcolor | \
                    alignleft aligncenter alignright alignjustify | \
                    bullist numlist outdent indent | removeformat | help'

    });
            
</script>
@endsection

