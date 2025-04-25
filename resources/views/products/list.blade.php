@extends('layouts.app')
@section('content')        
<main class="main">
    <div class="page-header text-center" 
         style="background-image: url('{{ asset('assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">{{ !empty($getSubCategory) ? $getSubCategory->name : $getCategory->name }}</h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:;">Shop</a></li>
                @if (!empty($getSubCategory))
                    <li class="breadcrumb-item"><a href="{{ url($getCategory->slug) }}">{{ $getCategory->name }}</a></li>
                    <li class="breadcrumb-item active">{{ $getSubCategory->name }}</li>
                @else    
                    <li class="breadcrumb-item active">{{ $getCategory->name }}</li>
                @endif
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="toolbox">
                        <div class="toolbox-left">
                            <div class="toolbox-info">
                                Showing <span>{{ $getProduct->firstItem() }} - {{ $getProduct->lastItem() }}</span> 
                                of {{ $getProduct->total() }} Products
                            </div>
                        </div>

                        <div class="toolbox-right">
                            <div class="toolbox-sort">
                                <label for="sortby">Sort by:</label>
                                <div class="select-custom">
                                    <select name="sortby" id="sortby" class="form-control">
                                        <option value="popularity">Most Popular</option>
                                        <option value="rating">Most Rated</option>
                                        <option value="date">Date</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="products mb-3">
                        <div class="row justify-content-center">
                            @forelse ($getProduct as $product)
                            @php
                                $productImage = $product->getImages()->first();
                            @endphp
                                <div class="col-12 col-md-4 col-lg-4 mb-4">
                                    <div class="product product-7 text-center">
                                        <figure class="product-media">
                                            <a href="{{ url($product->slug) }}">
                                               @if (!empty($productImage) && !empty($productImage->getProductImages()))
                                <img src="{{ $productImage->getProductImages() }}" 
                                     alt="{{ $product->title }}" 
                                     class="product-image"
                                     style="height: 280px; width: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('backend/upload/no-product-image.png') }}" 
                                     alt="No image available"
                                     class="product-image"
                                     style="height: 280px; width: 100%; object-fit: cover;">
                            @endif
                                            </a>
                                            <div class="product-action-vertical">
                                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable">
                                                    <span>add to wishlist</span>
                                                </a>
                                            </div>
                                        </figure>

                                        <div class="product-body">
                                            <div class="product-cat">
                                                <a href="{{ url($product->category_slug.'/'.$product->sub_category_slug) }}">
                                                    {{ $product->sub_category_name }}
                                                </a>
                                            </div>
                                            <h3 class="product-title">
                                                <a href="{{ url($product->slug) }}">{{ $product->title }}</a>
                                            </h3>
                                            <div class="product-price">₦{{ number_format($product->price, 2) }}</div>
                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    <div class="ratings-val" style="width: 20%;"></div>
                                                </div>
                                                <span class="ratings-text">( 2 Reviews )</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info">No products found.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @if($getProduct->hasPages())
                        <div class="d-flex justify-content-center mt-4 mb-5">
                            {!! $getProduct->appends(request()->except('page'))->links() !!}
                        </div>
                    @endif
                </div>

                <aside class="col-lg-3 order-lg-first">
                    <div class="sidebar sidebar-shop">
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">Category</h3>
                            <div class="widget-body">
                                <div class="filter-items filter-items-count">
                                    <!-- Add your category filters here -->
                                </div>
                            </div>
                        </div>

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">Price</h3>
                            <div class="widget-body">
                                <div class="filter-price">
                                    <!-- Add your price filter here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
.product {
    margin-bottom: 2rem;
    background: #fff;
    transition: box-shadow .35s ease;
    border: 1px solid #ebebeb;
}

.product:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.product-title {
    font-weight: 400;
    font-size: 1.4rem;
    line-height: 1.25;
    margin-bottom: 0.7rem;
}

.product-price {
    font-size: 1.4rem;
    font-weight: 600;
    color: #c96;
    margin-bottom: 1rem;
}

.ratings-val {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    background-color: #fcb941;
}

.page-header {
    padding: 4rem 0;
    background-color: #ebebeb;
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
}

.breadcrumb-nav {
    border-bottom: 1px solid #ebebeb;
    margin-bottom: 3rem;
}
</style>
@endpush