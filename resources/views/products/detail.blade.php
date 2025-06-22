@extends('layouts.app')

@section('meta_title', $meta_title)
@section('meta_description', $meta_description)
@section('style')
    <link rel="stylesheet" href="{{ url('assets/css/plugins/nouislider/nouislider.css') }}">
    <style type="text/css">
    .mt-4 {
    margin-top: 1rem; 
}
</style>
  
@endsection
@section('content')  

<main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container d-flex align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('get.category', [$product->getCategory->slug]) }}">
                                                        {{ $product->getCategory->name }}
                                                    </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('get.category', [$product->getCategory->slug, $product->getSubCategory->slug]) }}">
                                                        {{ $product->getSubCategory->name }}
                                                    </a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
                    </ol>
                </div>
            </nav>

            <div class="page-content">
                <div class="container">
                    <div class="product-details-top mb-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-gallery">
                                    <figure class="product-main-image">
                                         @php
                                            $productImage = $product->getImages()->first();
                                        @endphp

                                        @if(!empty($productImage) && !empty($productImage->getProductImages()))
                                            <img id="product-zoom" src="{{ $productImage->getProductImages() }}" data-zoom-image="{{ $productImage->getProductImages() }}" alt="{{ $product->title }}">

                                            <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                                <i class="icon-arrows"></i>
                                            </a>
                                        @endif
                                    </figure>

                                    <div id="product-zoom-gallery" class="product-image-gallery">
                                        @foreach ($product->getImages as $image)
                            
                                            <a class="product-gallery-item" href="#" data-image="{{ $image->getProductImages() }}" data-zoom-image="{{ $image->getProductImages() }}">
                                                <img src="{{ $image->getProductImages() }}" alt="product side">
                                            </a>
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="product-details">
                                    <h1 class="product-title">{{ $product->title }}</h1>

                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: {{ $product->getReviewsAvgRating($product->id) }}%;"></div>
                                        </div>

                                        <a class="ratings-text" href="#product-review-link" id="review-link">( {{ $product->getTotalReview() }} Reviews )</a>
                                    </div>

                                    <div class="product-price">
                                        ₦<span id="get-total-price">{{ number_format($product->price, 2)}}</span>
                                    </div>

                                    <div class="product-content">
                                        <p>{{ $product->short_description }} </p>
                                    </div>

                                    <form action="{{ route('products.add-to-cart') }}" method="POST" id="add-to-cart-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="product_price" value="{{ $product->price }}">
                                       @if ($product->productColours->count() > 0)
                                            <div class="details-filter-row details-row-size">
                                                <label for="color">Colour:</label>
                                                <div class="select-custom">
                                                    <select name="color_id" id="color-id" class="form-control" required>
                                                        <option value="">Select a colour</option>
                                                        @foreach ($product->productColours as $productColour)
                                                            @if ($productColour->getColours) <!-- Check if 'getColours' is not null -->
                                                                <option value="{{ $productColour->colour_id }}">
                                                                    {{ $productColour->getColours->name }}
                                                                </option>
                                                            @else
                                                                <option value="">No Colour Available</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif                                      

                                        @if ($product->productSizes->count() > 0)
                                            <div class="details-filter-row details-row-size">
                                                <label for="size">Size:</label>
                                                <div class="select-custom">
                                                    <select name="size_id" id="size" class="form-control get-size-price" required>
                                                        <option data-price="0" value="">Select a size</option>
                                                        @foreach ($product->productSizes as $size)
                                                            <option data-price="{{ !empty($size->price) ? $size->price : 0 }}" value="{{ $size->id }}">{{ $size->name }} 
                                                                @if (!empty($size->price)) (₦{{ number_format($size->price, 2) }}) @endif</option>
                                                                
                                                        @endforeach
                                                    </select>
                                                </div>                                        
                                            </div>
                                            
                                        @endif
                                        

                                        <div class="details-filter-row details-row-size">
                                            <label for="qty">Qty:</label>
                                            <div class="product-details-quantity">
                                                <input type="number" name="qty" id="qty" class="form-control" value="1" 
                                                min="1" max="100" step="1" data-decimals="0" required>
                                            </div>
                                        </div>

                                        <div class="product-details-action">
                                            <button style="background: #fff;color: #c96;" type="submit" class="btn-product btn-cart" id="add-to-cart" data-id="{{ $product->id }}" data-color="" data-size="">
                                                <span>add to cart</span>
                                            </button>

                                            <div class="details-action-wrapper">
                                                @auth
                                                    <a href="javascript:;" class="add-to-wishlist {{ !empty($product->checkWishlist($product->id)) ? 'btn-wishlist-add' : '' }} btn-product btn-wishlist" title="Wishlist" data-id="{{ $product->id }}">
                                                        <span>Add to Wishlist</span>
                                                    </a>
                                                    @else
                                                    <a href="#signin-modal" data-toggle="modal" class="btn-product-icon btn-wishlist btn-expendable" title="Wishlist">
                                                        <span>Add to Wishlist</span>
                                                    </a>
                                               @endauth
                                            </div>
                                        </div>
                                    </form>


                                    <div class="product-details-footer">
                                        <div class="product-cat">
                                            <span>Category:</span>
                                            <a href="{{ route('get.category', $product->getCategory->slug) }}">{{ $product->getCategory->name }}</a>,
                                            <a href="{{ route('get.category', $product->getCategory->slug . '/' . $product->getSubCategory->slug) }}">{{ $product->getSubCategory->name }}</a>
                                           
                                        </div>

                                        {{-- <div class="social-icons social-icons-sm">
                                            <span class="social-label">Share:</span>
                                            <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                            <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                            <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                            <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-details-tab product-details-extended">
                    <div class="container">
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Delivery & Returns</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews ({{ $product->getTotalReview() }})</a>
                            </li>
                        </ul>
                    </div><!-- End .container -->

                    <div class="tab-content">
                        @php
                            $tabs = [
                                ['id' => 'product-desc-tab', 'label' => 'Description', 'content' => $product->description],
                                ['id' => 'product-info-tab', 'label' => 'Additional Info', 'content' => $product->additional_info],
                                ['id' => 'product-shipping-tab', 'label' => 'Delivery & Returns', 'content' => $product->ship_and_returns],
                            ];
                        @endphp

                        @foreach ($tabs as $index => $tab)
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="{{ $tab['id'] }}" role="tabpanel" aria-labelledby="{{ $tab['id'] }}-link">
                                <div class="product-desc-content mt-4">
                                    <div class="container">
                                        {!! $tab['content'] !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                            <div class="reviews mt-4">
                                <div class="container">
                                    <h3>Reviews ({{ $product->getTotalReview() }})</h3>

                                    @foreach ($getProductReviews as $review)
                                        <div class="review mb-4 pb-3 border-bottom">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h4 class="mb-1">{{ $review->user_name }}</h4>
                                                    <div class="ratings-container mb-1">
                                                        <div class="ratings">
                                                            <div class="ratings-val" style="width: {{ $review->getReviewsPercentage() }}%;"></div>
                                                        </div>
                                                    </div>
                                                    <span class="text-muted small">{{ $review->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="col-md-9">
                                                    <p class="mb-0">{{ $review->review }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{ $getProductReviews->appends(request()->except('page'))->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="container">
                    <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
                    <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                        data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                },
                                "1200": {
                                    "items":4,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>

                        @foreach ($getRelatedProduct as $product)
                            @php
                                $productImage = $product->getImages()->first();
                            @endphp
                        
                            <div class="product product-7">
                                <figure class="product-media">
                                    
                                    <a href="{{ url($product->slug) }}">
                                        @if(!empty($productImage) && !empty($productImage->getProductImages()))
                                            <img src="{{ $productImage->getProductImages() }}" alt="{{ $product->title }}" class="product-image">
                                        @endif
                                    </a>

                                    <div class="product-action-vertical">
                                        @auth
                                            <a href="javascript:;" 
                                            class="add-to-wishlist {{ $product->checkWishlist($product->id) ? 'btn-wishlist-add' : '' }} btn-product-icon btn-wishlist btn-expandable" 
                                            title="Wishlist" 
                                            data-id="{{ $product->id }}">
                                                <span>Add to Wishlist</span>
                                            </a>
                                        @else
                                            <a href="#signin-modal" 
                                            data-toggle="modal" 
                                            class="btn-product-icon btn-wishlist btn-expandable" 
                                            title="Wishlist">
                                                <span>Add to Wishlist</span>
                                            </a>
                                        @endauth
                                    </div>

                                </figure>

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="{{ url($product->category_slug. '/' . $product->sub_category_slug) }}">{{ $product->sub_category_name }}</a>
                                    </div>
                                   <h3 class="product-title"><a href="{{ route('product.details', $product->slug) }}">{{ $product->title }}</a></h3>
                                    <div class="product-price">
                                        ₦{{ number_format($product->price, 2) }}
                                    </div>
                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: 20%;"></div>
                                        </div>
                                                    <span class="ratings-text">( 2 Reviews )</span>
                                    </div>

                                    
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </main>
         
@endsection

@section('script')

   
    <script src="{{ url('assets/js/bootstrap-input-spinner.js') }}"></script>
    <script src="{{ url('assets/js/jquery.elevateZoom.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap-input-spinner.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.get-size-price').on('change', function() {
                var productPrice = '{{ $product->price }}';
                var price = $(this).find(':selected').data('price');
                var totalPrice = parseFloat(productPrice) + parseFloat(price);
                
                $('#get-total-price').text(totalPrice.toFixed(2));
                
            });
        })
    </script>
   
@endsection
      
   