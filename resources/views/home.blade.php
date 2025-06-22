@extends('layouts.app')

@section('meta_title', $getPages->meta_title ?? 'Home')
@section('meta_description', $getPages->meta_description ?? 'Welcome to our online store, explore our latest products and offers')
@section('meta_keywords', $getPages->meta_keywords ?? 'home, products, offers, online store')

@section('style')
<style type="text/css">
.signup-cta {
    position: relative;
    background-size: cover;
    background-position: center;
    z-index: 1;
    color: white; 
}

.signup-cta::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); 
    z-index: -1;
}
</style>

@endsection

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
                                        </figure>

                                        <div class="intro-content">
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
                            
                        </div>
                        
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
                <h2 class="title-lg">{{ !empty($getHomeSetting->trendy_product_title) ? $getHomeSetting->trendy_product_title : 'Trendy Products' }}</h2>
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
            <h2 class="title-lg text-center mb-4">{{ !empty($getHomeSetting->shop_category_title) ? $getHomeSetting->shop_category_title : '' }}</h2><!-- End .title-lg text-center -->

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
            <h2 class="title">{{ ($getHomeSetting->recent_arrival_title) ? $getHomeSetting->recent_arrival_title : 'Recent Arrivals' }}</h2><!-- End .title -->

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
            @if (!empty($getHomeSetting->payment_delivery_title))
                
                <div class="col-lg-4 col-sm-6">
                    <div class="icon-box icon-box-card text-center">
                        @if (!empty($getHomeSetting->getPaymentImage()))
                            <span class="icon-box-icon">
                                <img style="width: 50px;" src="{{ $getHomeSetting->getPaymentImage() }}">
                            </span>   
                        @endif
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">{{ $getHomeSetting->payment_delivery_title }}</h3>
                            <p>{{ $getHomeSetting->payment_delivery_description }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (!empty($getHomeSetting->refund_title))
                
                <div class="col-lg-4 col-sm-6">
                    <div class="icon-box icon-box-card text-center">
                        @if (!empty($getHomeSetting->getRefundImage()))
                            <span class="icon-box-icon">
                                <img style="width: 50px;" src="{{ $getHomeSetting->getRefundImage() }}">
                            </span>   
                        @endif
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">{{ $getHomeSetting->refund_title }}</h3>
                            <p>{{ $getHomeSetting->refund_description }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (!empty($getHomeSetting->support_title))
                
                <div class="col-lg-4 col-sm-6">
                    <div class="icon-box icon-box-card text-center">
                        @if (!empty($getHomeSetting->getSupportImage()))
                            <span class="icon-box-icon">
                                <img style="width: 50px;" src="{{ $getHomeSetting->getSupportImage() }}">
                            </span>   
                        @endif
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">{{ $getHomeSetting->support_title }}</h3>
                            <p>{{ $getHomeSetting->support_description }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="mb-2"></div>
    </div>

    @if(!empty($getBlog->count()))
    <div class="blog-posts pt-7 pb-7" style="background-color: #fafafa;">
        <div class="container">
            <h2 class="title-lg text-center mb-3 mb-md-4">{{ !empty($getHomeSetting->blog_title) ? $getHomeSetting->blog_title : 'Our Blog' }}</h2>

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

                @foreach ($getBlog as $blog)               
                <article class="entry entry-display">
                    <figure class="entry-media">
                        <a href="{{ url('blogs/'.$blog->slug) }}">
                            <img style="height: 260px; object-fit: cover;" src="{{ $blog->getImage() }}" alt="{{ $blog->title }}">
                        </a>
                    </figure>

                    <div class="entry-body pb-4 text-center">
                        <div class="entry-meta">
                            <a href="#">{{ date('M d, Y', strtotime($blog->created_at)) }}</a>, {{ $blog->getCommentsCount() }} Comments
                        </div>

                        <h3 class="entry-title">
                            <a href="{{ url('blogs/'.$blog->slug) }}">{{ $blog->title }}</a>
                        </h3>

                        <div class="entry-content">
                            <p>{!! $blog->short_description !!}</p>
                            <a href="{{ url('blogs/'.$blog->slug) }}" class="read-more">Read More</a>
                        </div>
                    </div>
                </article>
                @endforeach

            </div>
        </div>

        <div class="more-container text-center mb-0 mt-3">
            <a href="{{ route('blogs') }}" class="btn btn-outline-darker btn-more"><span>View more articles</span><i class="icon-long-arrow-right"></i></a>
        </div><!-- End .more-container -->
    </div>
    @endif

    @if(!empty($getHomeSetting->signup_title))
        <div class="cta cta-display bg-image pt-4 pb-4 signup-cta" style="background-image: url('{{ $getHomeSetting->getSignupImage() }}');">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9 col-xl-8">
                        <div class="row no-gutters flex-column flex-sm-row align-items-sm-center">
                            <div class="col">
                                <h3 class="cta-title text-white">{{ $getHomeSetting->signup_title }}</h3>
                                <p class="cta-desc text-white">{{ $getHomeSetting->signup_description }}</p>
                            </div>

                            <div class="col-auto">
                                @guest
                                    <a href="#signin-modal" data-toggle="modal" class="btn btn-outline-white"><span>SIGN UP</span><i class="icon-long-arrow-right"></i></a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
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

      
   