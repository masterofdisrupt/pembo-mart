@extends('layouts.app')

@section('meta_title', $meta_title)
@section('meta_description', $meta_description)
@section('meta_keywords', $meta_keywords)

@section('style')

@endsection

@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
        	<h1 class="page-title">Shopping Cart<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="cart">
	        <div class="container">

                @if(!empty(Cart::getContent()->count()))

                    <div class="row">
                        <div class="col-lg-9">
                            <form action="{{ route('update.cart') }}" method="POST">
                                @csrf
                                <table class="table table-cart table-mobile">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Cart::getContent() as $key => $cart)
                                            @php
                                                $getCartProduct = App\Models\Backend\V1\ProductModel::getSingleRecord($cart->id);
                                                $productImage = $getCartProduct?->getImages()->first();
                                            @endphp

                                            @if($getCartProduct)
                                            <tr>
                                                <td class="product-col">
                                                    <div class="product">
                                                        <figure class="product-media">
                                                            <a href="{{ route('product.details', $getCartProduct->slug) }}">
                                                                <img src="{{ $productImage->getProductImages() }}" alt="Product image" loading="lazy">
                                                            </a>
                                                        </figure>
                                                        <h3 class="product-title">
                                                            <a style="margin-bottom: 10px; display: block;" href="{{ route('product.details', $getCartProduct->slug) }}">{{ $getCartProduct->title }}</a>

                                                            @php
                                                                $colour_id = $cart->attributes->colour_id ?? null;
                                                            @endphp
                                                            @if(!empty($colour_id))
                                                            @php
                                                                $getColour = App\Models\Backend\V1\ColourModel::getSingleRecord($colour_id);
                                                            @endphp
                                                            <div>
                                                                <span class="product-colour" style="background-color: {{ $getColour->name }}; width: 20px; height: 20px; display: inline-block; border-radius: 50%;"></span>
                                                            </div>
                                                            @endif

                                                            @php
                                                                $size_id = $cart->attributes->size_id ?? null;
                                                            @endphp
                                                            @if(!empty($size_id))
                                                                @php
                                                                    $getSize = App\Models\Backend\V1\ProductSizesModel::getSingleRecord($size_id);
                                                                @endphp
                                                                <span class="product-size"><b>Size:&nbsp; </b>{{ $getSize->name }} (₦{{ number_format($getSize->price, 2) }}) </span>
                                                            @endif

                                                        </h3>
                                                    </div>
                                                </td>
                                                <td class="price-col">₦{{ number_format($cart->price, 2) }}</td>
                                                <td class="quantity-col">
                                                    <div class="cart-product-quantity">
                                                        <input type="number" name="cart[{{ $key }}][qty]" class="form-control" value="{{ $cart->quantity }}" min="1" max="10" step="1" required>
                                                    </div>

                                                    <input type="hidden" name="cart[{{ $key }}][id]" value="{{ $cart->id }}">
                                                </td>
                                                <td class="total-col">₦{{ number_format($cart->price * $cart->quantity, 2) }}</td>
                                                <td class="remove-col">
                                                    <button type="button" class="btn-remove" onclick="document.getElementById('delete-form-{{ $cart->id }}').submit()" style="background: none; border: none;">
                                                        <i class="icon-close"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>

                                
                                <div class="cart-bottom">
                                    
                                    <button type="submit" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></button>
                                </div>
                            </form>

                          
                            @foreach(Cart::getContent() as $cart)
                                <form id="delete-form-{{ $cart->id }}" action="{{ route('delete.cart.item', $cart->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endforeach

                                </div>
                                <aside class="col-lg-3">
                                    <div class="summary summary-cart">
                                        <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                                        <table class="table table-summary">
                                            <tbody>
                                                <tr class="summary-subtotal">
                                                    <td>Subtotal:</td>
                                                    <td>₦{{ number_format(Cart::getSubTotal(), 2) }}</td>
                                                </tr>

                                                <tr class="summary-total">
                                                    <td>Total:</td>
                                                    <td>₦{{ number_format(Cart::getSubTotal(), 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <a href="{{ route('checkout') }}" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                                    </div>

                                    <a href="{{ route('home') }}" class="btn btn-outline-dark-2 btn-block mb-3"><span>BROWSE MEALS</span><i class="icon-refresh"></i></a>
                                </aside>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <h3>Your cart is empty</h3>
                                    <a href="{{ route('home') }}" class="btn btn-outline-dark-2 mb-3" style="min-width: 200px;">
                                        <span>CONTINUE SHOPPING</span><i class="icon-refresh"></i>
                                    </a>
                                </div>
                            </div>

                        @endif
	                </div>
                </div>
            </div>
        </main>

@endsection

@section('script')
<script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "timeOut": "6000"
    };

    window.onload = function () {
        @if(session('success'))
        @endif

        @if($errors->any())
            @foreach ($errors->all() as $error)
               
            @endforeach
        @endif
    };
</script>
@endsection
