@extends('layouts.app')

@section('meta_title', $getPages->meta_title ?? 'Default Title')
@section('meta_description', $getPages->meta_description ?? 'Default description')
@section('meta_keywords', $getPages->meta_keywords ?? 'default,keywords')
@section('content')        

        <main class="main">
            <div class="intro-section bg-lighter pb-6">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="intro-slider-container slider-container-ratio slider-container-1 mb-2 mb-lg-0">
                                <div class="intro-slider intro-slider-1 owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{
                                        "nav": false, 
                                        "responsive": {
                                            "768": {
                                                "nav": true
                                            }
                                        }
                                    }'>

                                    @foreach ($getSlider as $slider)
                                        @if (!empty($slider->getSliderImage()))
                                        
                                            <div class="intro-slide">
                                                <figure class="slide-image">
                                                    <picture>
                                                        <source media="(max-width: 480px)" srcset="{{ $slider->getSliderImage() }}">
                                                        <img src="{{ $slider->getSliderImage() }}" alt="Image Desc">
                                                    </picture>
                                                </figure><!-- End .slide-image -->

                                                <div class="intro-content">
                                                    <h3 class="intro-subtitle">Topsale Collection</h3><!-- End .h3 intro-subtitle -->
                                                    <h1 class="intro-title">
                                                        {!! $slider->title !!}
                                                    </h1>

                                                    @if (!empty($slider->button_link) && !empty($slider->button_name))
                                                        
                                                        <a href="{{ $slider->button_link }}" class="btn btn-outline-white">
                                                            <span>{{ $slider->button_name }}</span>
                                                            <i class="icon-long-arrow-right"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                  
                                </div><!-- End .intro-slider owl-carousel owl-simple -->
                                
                                <span class="slider-loader"></span>
                            </div>
                        </div>
                    </div>

                    @if ($getPartners->count())
                        <div class="mb-6"></div>

                        <div class="owl-carousel owl-simple" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": false,
                                "margin": 30,
                                "loop": false,
                                "responsive": {
                                    "0": {"items": 2},
                                    "420": {"items": 3},
                                    "600": {"items": 4},
                                    "900": {"items": 5},
                                    "1024": {"items": 6}
                                }
                            }'>
                            
                            @foreach ($getPartners as $partner) 
                                @if (!empty($partner->getPartnerImage()))
                                    <a href="{{ $partner->button_link ?? '#' }}" class="brand">
                                        <img 
                                            src="{{ asset($partner->getPartnerImage()) }}" 
                                            alt="{{ $partner->name ?? 'Brand' }}" 
                                            loading="lazy"
                                            class="img-fluid"
                                        >
                                    </a>
                                @endif
                            @endforeach

                        </div>
                    @endif

                </div>
            </div>

            <div class="mb-6"></div>
            @if (!empty($getTrendyProduct->count()))
                <div class="container">
                    <div class="heading heading-center mb-3">
                        <h2 class="title-lg">Trendy Products</h2>
                    </div>

                    <div class="tab-content tab-content-carousel">
                        <div class="tab-pane p-0 fade show active" id="trendy-all-tab" role="tabpanel" aria-labelledby="trendy-all-link">
                            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                                data-owl-options='{
                                    "nav": false, 
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":2
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
                                @foreach ($getTrendyProduct as $product)
                                   @php
                                        $productImage = $product->getImages()->first();
                                    @endphp
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
                                    
                                @endforeach
                            </div><!-- End .owl-carousel -->
                        </div>
                    </div>
                </div>
             @endif
            @if (!empty($getCategory->count()))
                
                <div class="container categories pt-6">
                    <h2 class="title-lg text-center mb-4">Shop by Categories</h2><!-- End .title-lg text-center -->

                    <div class="row">

                        @foreach ($getCategory as $category) 
                            @if (!empty($category->getCategoryImage()))                    
                                <div class="col-sm-12 col-lg-4 banners-sm">
                                    <div class="banner banner-display banner-link-anim col-lg-12 col-6">
                                        <a href="{{ route('get.category', [$category->slug]) }}">
                                            <img src="{{ $category->getCategoryImage() }}" alt="{{ $category->name }}">
                                        </a>

                                        <div class="banner-content banner-content-center">
                                            <h3 class="banner-title text-white"><a href="{{ route('get.category', [$category->slug]) }}">{{ $category->name }}</a></h3>
                                            @if (!empty($category->button_name))
                                                <a href="{{ route('get.category', [$category->slug]) }}" class="btn btn-outline-white banner-link">{{ $category->button_name }}<i class="icon-long-arrow-right"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif  
                        @endforeach
                    </div>
                </div>

                <div class="mb-5"></div>
            @endif

            
            <div class="container">
                <div class="heading heading-center mb-6">
                    <h2 class="title">Recent Arrivals</h2><!-- End .title -->

                    <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="top-all-link" data-toggle="tab" href="#top-all-tab" role="tab" aria-controls="top-all-tab" aria-selected="true">All</a>
                        </li>

                        @foreach ($getCategory as $category)
                            <li class="nav-item">
                                <a class="nav-link get-category-product" data-id="{{ $category->id }}" id="top-{{ $category->slug }}-link" data-toggle="tab" href="#top-{{ $category->slug }}-tab" role="tab" 
                                    aria-controls="top-{{ $category->slug }}-tab" aria-selected="false">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
                        <div class="products">
                            @php
                                $is_home = 1; 
                            @endphp
                            @include('products._list')
                        </div>
                         <div class="more-container text-center">
                            <a href="{{ route('search') }}" class="btn btn-outline-darker btn-more"><span>Load more products</span><i class="icon-long-arrow-down"></i></a>
                        </div>
                    </div>
                    @foreach ($getCategory as $category)
                        
                        <div class="tab-pane p-0 fade get-category-product{{ $category->id }}" id="top-{{ $category->slug }}-tab" role="tabpanel" aria-labelledby="top-{{ $category->slug }}-link">
                            

                        </div>
                    @endforeach       
                    
                </div>
               
            </div>

            <div class="container">
                <hr>
            	<div class="row justify-content-center">
                    <div class="col-lg-4 col-sm-6">
                        <div class="icon-box icon-box-card text-center">
                            <span class="icon-box-icon">
                                <i class="icon-rocket"></i>
                            </span>
                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Payment & Delivery</h3><!-- End .icon-box-title -->
                                <p>Free shipping for orders over $50</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-lg-4 col-sm-6 -->

                    <div class="col-lg-4 col-sm-6">
                        <div class="icon-box icon-box-card text-center">
                            <span class="icon-box-icon">
                                <i class="icon-rotate-left"></i>
                            </span>
                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Return & Refund</h3><!-- End .icon-box-title -->
                                <p>Free 100% money back guarantee</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-lg-4 col-sm-6 -->

                    <div class="col-lg-4 col-sm-6">
                        <div class="icon-box icon-box-card text-center">
                            <span class="icon-box-icon">
                                <i class="icon-life-ring"></i>
                            </span>
                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Quality Support</h3><!-- End .icon-box-title -->
                                <p>Alway online feedback 24/7</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-lg-4 col-sm-6 -->
                </div><!-- End .row -->

                <div class="mb-2"></div><!-- End .mb-2 -->
            </div><!-- End .container -->
            <div class="blog-posts pt-7 pb-7" style="background-color: #fafafa;">
                <div class="container">
                   <h2 class="title-lg text-center mb-3 mb-md-4">From Our Blog</h2><!-- End .title-lg text-center -->

                    <div class="owl-carousel owl-simple carousel-with-shadow" data-toggle="owl" 
                        data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "items": 3,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "600": {
                                    "items":2
                                },
                                "992": {
                                    "items":3
                                }
                            }
                        }'>
                        <article class="entry entry-display">
                            <figure class="entry-media">
                                <a href="single.html">
                                    <img src="assets/images/blog/home/post-1.jpg" alt="image desc">
                                </a>
                            </figure><!-- End .entry-media -->

                            <div class="entry-body pb-4 text-center">
                                <div class="entry-meta">
                                    <a href="#">Nov 22, 2018</a>, 0 Comments
                                </div><!-- End .entry-meta -->

                                <h3 class="entry-title">
                                    <a href="single.html">Sed adipiscing ornare.</a>
                                </h3><!-- End .entry-title -->

                                <div class="entry-content">
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit.<br>Pelletesque aliquet nibh necurna. </p>
                                    <a href="single.html" class="read-more">Read More</a>
                                </div><!-- End .entry-content -->
                            </div><!-- End .entry-body -->
                        </article><!-- End .entry -->

                        <article class="entry entry-display">
                            <figure class="entry-media">
                                <a href="single.html">
                                    <img src="assets/images/blog/home/post-2.jpg" alt="image desc">
                                </a>
                            </figure><!-- End .entry-media -->

                            <div class="entry-body pb-4 text-center">
                                <div class="entry-meta">
                                    <a href="#">Dec 12, 2018</a>, 0 Comments
                                </div><!-- End .entry-meta -->

                                <h3 class="entry-title">
                                    <a href="single.html">Fusce lacinia arcuet nulla.</a>
                                </h3><!-- End .entry-title -->

                                <div class="entry-content">
                                    <p>Sed pretium, ligula sollicitudin laoreet<br>viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis justo. </p>
                                    <a href="single.html" class="read-more">Read More</a>
                                </div><!-- End .entry-content -->
                            </div><!-- End .entry-body -->
                        </article><!-- End .entry -->

                        <article class="entry entry-display">
                            <figure class="entry-media">
                                <a href="single.html">
                                    <img src="assets/images/blog/home/post-3.jpg" alt="image desc">
                                </a>
                            </figure><!-- End .entry-media -->

                            <div class="entry-body pb-4 text-center">
                                <div class="entry-meta">
                                    <a href="#">Dec 19, 2018</a>, 2 Comments
                                </div><!-- End .entry-meta -->

                                <h3 class="entry-title">
                                    <a href="single.html">Quisque volutpat mattis eros.</a>
                                </h3><!-- End .entry-title -->

                                <div class="entry-content">
                                    <p>Suspendisse potenti. Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. </p>
                                    <a href="single.html" class="read-more">Read More</a>
                                </div><!-- End .entry-content -->
                            </div><!-- End .entry-body -->
                        </article><!-- End .entry -->
                    </div><!-- End .owl-carousel -->
                </div><!-- container -->

                <div class="more-container text-center mb-0 mt-3">
                    <a href="blog.html" class="btn btn-outline-darker btn-more"><span>View more articles</span><i class="icon-long-arrow-right"></i></a>
                </div><!-- End .more-container -->
            </div>
            <div class="cta cta-display bg-image pt-4 pb-4" style="background-image: url(assets/images/backgrounds/cta/bg-6.jpg);">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-9 col-xl-8">
                            <div class="row no-gutters flex-column flex-sm-row align-items-sm-center">
                                <div class="col">
                                    <h3 class="cta-title text-white">Sign Up & Get 10% Off</h3><!-- End .cta-title -->
                                    <p class="cta-desc text-white">Molla presents the best in interior design</p><!-- End .cta-desc -->
                                </div>

                                <div class="col-auto">
                                    <a href="login.html" class="btn btn-outline-white"><span>SIGN UP</span><i class="icon-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('.get-category-product').on('click', function(e) {
            e.preventDefault(); 

            var category_id = $(this).data('id');
            var url = "{{ route('recent.arrivals') }}"; 

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    category_id: category_id
                },
                dataType: 'json',
                success: function(response) {
                    $('.get-category-product' + category_id).html(response.success);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

@endsection

      
   