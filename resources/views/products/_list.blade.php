<div class="products mb-3">
    <div class="row justify-content-center">
        @foreach ($getProduct as $product)
            @php
                $productImage = $product->getImages()->first();
            @endphp

        <div class="col-12 @if(!empty($is_home)) col-md-3 col-lg-3 @else col-md-4 col-lg-4 @endif">
        
            <div class="product product-7 text-center">
                <figure class="product-media">

                    <a href="{{ route('product.details', $product->slug) }}">
                        @if (!empty($productImage) && !empty($productImage->getProductImages()))
                            <img 
                            src="{{ $productImage->getProductImages() }}" 
                            alt="{{ $product->title }}" 
                            class="product-image"
                            style="height: 280px; width: 100%; object-fit: cover;">
                        
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
                            <div class="ratings-val" style="width: {{ $product->getReviewsAvgRating($product->id) }}%;"></div>
                        </div>
                        <span class="ratings-text">( {{ $product->getTotalReview() }} Reviews )</span>
                    </div>
                </div>
            </div>                                    
        </div>
        @endforeach

        
    </div>
</div>
