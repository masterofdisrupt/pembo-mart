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
                                <label>Brand <span class="text-danger">*</span></label>
                                <select class="form-control" name="brand_id" required>
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
                                <label>SKU <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="sku" value="{{ old('sku', $product->sku) }}" required>
                                @error('sku')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Sub Category <span class="text-danger">*</span></label>
                                <select id="sub_category_id" class="form-control" name="sub_category_id" required>
                                    <option value="">Select Sub Category</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" {{ old('sub_category_id', $product->sub_category_id) == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                        
                                    @endforeach
                                </select>
                                @error('sub_category_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Colour <span class="text-danger">*</span></label>
                                <div class="row">
                                   @foreach ($getColour as $colour)
                                        @php
                                            $isChecked = false;
                                            foreach ($product->getColours as $productColour) {
                                                if ($productColour->colour_id == $colour->id) {
                                                    $isChecked = true;
                                                    break;
                                                }
                                            }
                                        @endphp

                                        @foreach ($product->getColours as $productColour)
                                            @if ($productColour->colour_id == $colour->id)
                                                <input type="hidden" name="old_colour_id[]" value="{{ $colour->id }}">
                                            @endif
                                        @endforeach

                                        <div class="col-6 col-sm-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="colour_id[]" value="{{ $colour->id }}" id="colour{{ $colour->id }}" {{ $isChecked ? 'checked' : '' }}>
                                                <label class="form-check-label" for="colour{{ $colour->id }}">{{ $colour->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                @error('colour_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- ROW 3: Price + Old Price --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Price (₦) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="price" value="{{ !empty($product->price) ? $product->price : '' }}" step="0.01" required>
                                @error('price')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Old Price (₦) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="old_price" value="{{ !empty($product->old_price) ? $product->old_price : '' }}" step="0.01" required>
                                @error('old_price')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- SIZE TABLE --}}
                        <div class="mb-4">
                            <label>Size <span class="text-danger">*</span></label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price (₦)</th>
                                        <th style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="size-rows">
                                    @php $i = 0; @endphp
                                    @foreach ($product->getSizes as $size)                    
                                        <tr id="delete-row{{ $i }}">
                                            <td><input type="text" class="form-control" value="{{ $size->name }}" name="size[{{ $i }}][name]" placeholder="Enter Size Name"></td>
                                            <td><input type="number" class="form-control" value="{{ $size->price }}" name="size[{{ $i }}][price]" placeholder="Enter Size Price" step="0.01"></td>
                                            <td><button type="button" class="btn btn-danger delete-row" data-row="delete-row{{ $i }}">Delete</button></td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach

                                    <!-- Initial empty row for adding new sizes -->
                                    <tr>
                                        <td><input type="text" class="form-control" name="size[{{ $i }}][name]" placeholder="Enter Size Name"></td>
                                        <td><input type="number" class="form-control" name="size[{{ $i }}][price]" placeholder="Enter Size Price" step="0.01"></td>
                                        <td><button type="button" class="btn btn-success add-row">Add</button></td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>

                        {{-- IMAGE --}}
                        <div class="mb-4">
                            <label>Image</label>
                            <input type="file" class="form-control" name="image[]" multiple accept="image/*" style="padding: 6px;">
                        </div>

                        {{-- DESCRIPTIONS --}}
                        <div class="mb-3">
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
                            <label>Additional Information <span class="text-danger">*</span></label>
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
<script src="{{ url('public/assets/js/tinymce-jquery.min.js') }}"></script>

<script type="text/javascript">

      $('.editor').tinymce({
        height: 500,
        menubar: false,
        plugins: [
          'a11ychecker', 'accordion', 'advlist', 'anchor', 'autolink', 'autosave',
          'charmap', 'code', 'codesample', 'directionality', 'emoticons', 'exportpdf',
          'exportword', 'fullscreen', 'help', 'image', 'importcss', 'importword',
          'insertdatetime', 'link', 'lists', 'markdown', 'math', 'media', 'nonbreaking',
          'pagebreak', 'preview', 'quickbars', 'save', 'searchreplace', 'table',
          'visualblocks', 'visualchars', 'wordcount'
        ],
        toolbar: 'undo redo | accordion accordionremove | ' +
          'importword exportword exportpdf | math | ' +
          'blocks fontfamily fontsize | bold italic underline strikethrough | ' +
          'align numlist bullist | link image | table media | ' +
          'lineheight outdent indent | forecolor backcolor removeformat | ' +
          'charmap emoticons | code fullscreen preview | save print | ' +
          'pagebreak anchor codesample | ltr rtl',
        menubar: 'file edit view insert format tools table help'
      });


  
    let i = {{ $i + 1 }}; // Continue index from PHP
    const maxRows = 10; // Change this to your desired limit

    $('body').on('click', '.add-row', function () {
        const lastRow = $('#size-rows tr').last();
        const lastName = lastRow.find('input[name*="[name]"]').val();
        const lastPrice = lastRow.find('input[name*="[price]"]').val();

        // Simple validation: Don't add if last row is empty
        if (!lastName || !lastPrice) {
            alert('Please fill in the current size name and price before adding another.');
            return;
        }

        // Limit check
        const totalRows = $('#size-rows tr').length - 1; // exclude the Add row
        if (totalRows >= maxRows) {
            alert(`You can only add up to ${maxRows} size options.`);
            return;
        }

        const html = `
            <tr id="delete-row${i}">
                <td><input type="text" class="form-control" name="size[${i}][name]" placeholder="Enter Size Name" required></td>
                <td><input type="number" class="form-control" name="size[${i}][price]" placeholder="Enter Size Price" step="0.01" required></td>
                <td><button type="button" class="btn btn-danger delete-row" data-row="delete-row${i}">Delete</button></td>
            </tr>`;
        $('#size-rows').append(html);
        i++;
    });

    $('body').on('click', '.delete-row', function () {
        const rowId = $(this).data('row');
        $('#' + rowId).remove();
    });


    $(document).ready(function () {
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
                // If no category selected, reset subcategory dropdown
                $('#sub_category_id').empty().append('<option value="">Select Sub Category</option>');
            }
        });
    });
</script>
@endsection

