<header class="header">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">

                        <div class="header-dropdown">
                            <a href="#">Eng</a>
                            <div class="header-menu">
                                <ul>
                                    <li><a href="#">English</a></li>
                                    
                                </ul>
                            </div>
                        </div>

                        @php
                            $walletBalance = auth()->user()->wallet ?? 0;
                        @endphp

                        <div class="wallet-info" style="margin-left: 20px;">
                            <i class="fas fa-wallet" style="color: #28a745;"></i>
                            <span style="margin-left: 5px; font-weight: 500;">
                                ₦{{ number_format($walletBalance, 2) }}
                            </span>

                            @if ($walletBalance < 500)
                                <span style="color: #dc3545; font-size: 13px; margin-left: 10px;">
                                    <i class="fas fa-exclamation-triangle"></i> Low Wallet Balance
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="header-right" id="header-auth-section">
                        <ul class="top-menu">
                            <li>
                                <a href="#">Links</a>
                                <ul>
                                    <li><a href="tel:{{ $getSystemSettingApp->phone }}"><i class="icon-phone"></i>Call: {{ $getSystemSettingApp->phone }}</a></li>

                                    @if (Auth::check())
                                    <li><a href="{{ route('my.wishlist') }}"><i class="icon-heart-o"></i>My Wishlist</a></li>
                                    @else
                                    <li><a href="#signin-modal" data-toggle="modal"><i class="icon-heart-o"></i>My Wishlist</a></li>
                                    @endif
                                    <li><a href="{{ url('about') }}">About Us</a></li>
                                    <li><a href="{{ url('contact') }}">Contact Us</a></li>
                                   @if (Auth::check())
                                        <li class="dropdown">
                                            <a href="{{ route('user.dashboard') }}">
                                                <i class="icon-user"></i> {{ Auth::user()->name }}
                                            </a>
                                        </li>
                                    @else
                                        <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>Login</a></li>
                                    @endif


                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="header-middle sticky-header">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>

                        <a href="{{ route('home') }}" class="logo">
                            <img src="{{ $getSystemSettingApp->getLogo() }}" alt="Pembo-Mart Logo" width="105" height="25">
                        </a>

                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="{{ (Request::segment(1) == '') ? 'active' : '' }}">
                                    <a href="{{ route('home') }}">Home</a> 
                                </li>
                                <li>
                                    <a href="javascript:;" class="sf-with-ul">Shop</a>

                                    <div class="megamenu megamenu-md">
                                        <div class="row no-gutters">
                                            <div class="col-md-12">
                                                <div class="menu-col">
                                                    <div class="row">
                                                    @php
                                                        $getCategoryHeader = App\Models\Backend\V1\CategoryModel::getCategoryStatusMenu();
                                                    @endphp

                                                    @foreach ($getCategoryHeader as $category)
                                                        @if ($category->getSubCategories->count())
                                                            <div class="col-md-4">
                                                                <a href="{{ route('get.category', [$category->slug]) }}" class="menu-title">
                                                                    {{ $category->name }}
                                                                </a>
                                                                <ul>
                                                                    @foreach ($category->getSubCategories as $subCategory)
                                                                        <li>
                                                                            <a href="{{ route('get.category', [$category->slug, $subCategory->slug]) }}">
                                                                                {{ $subCategory->name }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </li> 
                                @php
                                    $getCategoryHeaderMenu = App\Models\Backend\V1\CategoryModel::getCategoryHeaderMenu();
                                @endphp
                                @foreach ($getCategoryHeaderMenu as $menu)
                                    <li class="{{ (Request::segment(1) == $menu->slug) ? 'active' : '' }}">
                                        <a href="{{ route('get.category', [$menu->slug]) }}">{{ $menu->name }}</a> 
                                    </li>   
                                @endforeach                               
                            </ul>
                        </nav>
                    </div>

                    <div class="header-right">
                        <div class="header-search">
                            <a href="#" class="search-toggle" role="button" title="Search"><i class="icon-search"></i></a>
                            <form action="{{ route('search') }}" method="get">
                                <div class="header-search-wrapper">
                                    <label for="search" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="search" id="search" placeholder="Search in..." 
                                    value="{{ !empty(request('search'))? request('search') : '' }}" required>
                                </div>
                            </form>
                        </div>

                        <div class="dropdown cart-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-shopping-cart"></i>
                                <span class="cart-count">{{ Cart::getContent()->count() }}</span>
                            </a>

                            @if (Cart::getContent()->count() > 0)
                                
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-cart-products">
                                    @foreach(Cart::getContent() as $cart)
                                    @php
                                        $getCartProduct = App\Models\Backend\V1\ProductModel::getSingleRecord($cart->id);
                                        
                                    @endphp

                                        @if (!empty($getCartProduct))
                                              @php
                                                $productImage = $getCartProduct->getImages()->first(); 
                                            @endphp
                                                                           
                                            <div class="product">
                                                <div class="product-cart-details">
                                                    <h4 class="product-title">
                                                        <a href="{{ url($getCartProduct->slug) }}">{{ $getCartProduct->title }}</a>
                                                    </h4>

                                                    <span class="cart-product-info">
                                                        <span class="cart-product-qty">{{ $cart->quantity }}</span>
                                                        x ₦{{ number_format($cart->price, 2) }}
                                                    </span>
                                                </div>

                                                <figure class="product-image-container">
                                                    <a href="" class="product-image">
                                                        <img src="{{ $productImage->getProductImages() }}" alt="product">
                                                    </a>
                                                </figure>
                                                <form action="{{ route('delete.cart.item', $cart->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-remove" title="Remove Product" style="background: none; border: none;">
                                                        <i class="icon-close"></i>
                                                    </button>
                                                </form>
                                                
                                            </div>
                                         @endif
                                    @endforeach

                                    
                                </div>

                                <div class="dropdown-cart-total">
                                    <span>Total</span>

                                    <span class="cart-total-price">₦{{ number_format(Cart::getSubTotal(), 2) }}</span>
                                </div>

                                <div class="dropdown-cart-action">
                                    <a href="{{ route('cart') }}" class="btn btn-primary">View Cart</a>
                                    <a href="{{ route('checkout') }}" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>