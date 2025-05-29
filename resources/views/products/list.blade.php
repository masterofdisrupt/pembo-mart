@extends('layouts.app')
@section('style')
    
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/nouislider/nouislider.css') }}">
    <style type="text/css">
        .active-color {
            border: 3px solid #000 !important;
        }

        .spin {
    animation: spin 1s infinite linear;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.btn-load-more {
    position: relative;
    min-width: 180px;
}

.btn-load-more.loading {
    opacity: 0.7;
    cursor: not-allowed;
}

    </style>
@endsection
@section('content')        
         <main class="main">
        	<div class="page-header text-center" style="background-image: url('{{ url('') }}/assets/images/page-header-bg.jpg')">
        		<div class="container">
                   @if (isset($getSubCategory) && !empty($getSubCategory))
                        <h1 class="page-title">{{ $getSubCategory->name }}</h1>
                    @elseif (isset($getCategory) && !empty($getCategory))
                        <h1 class="page-title">{{ $getCategory->name }}</h1>
                    @elseif (Request::has('search'))
                        <h1 class="page-title">Search Results for: {{ Request::get('search') }}</h1>
                    @else
                        <h1 class="page-title">Products</h1>
                    @endif

        		</div>
        	</div>
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Shop</a></li>
                        @if (!empty($getSubCategory))
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ url($getCategory->slug) }}">{{ $getCategory->name }}</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $getSubCategory->name }}</li>

                        @elseif (!empty($getCategory))   
                            <li class="breadcrumb-item active" aria-current="page">{{ $getCategory->name }}</li>

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
											<select name="sortby" id="sortby" class="form-control changeSortBy">
                                                <option value="">Select</option>
												<option value="popularity">Most Popular</option>
												<option value="rating">Most Rated</option>
												<option value="date">Date</option>
											</select>
										</div>
                					</div>
                				</div>
                			</div>

                            <div id="get-product-list">
                                @include('products._list')
                            </div>

                                <div class="load-more-wrapper text-center my-4">
                                    @if ($getProduct->hasMorePages())
                                        <button type="button" 
                                                class="btn btn-outline-primary btn-load-more {{ !isset($page) ? 'd-none' : '' }}"
                                                data-page="{{ $page ?? '' }}">
                                            Load More Products
                                            <i class="icon-refresh spin ml-2"></i>
                                        </button>
                                    @endif
                                </div>
                		    </div>

                		<aside class="col-lg-3 order-lg-first">
                           <form id="filter-form" method="POST" action="">
                                @csrf
                                <input type="hidden" name="search" value="{{ !empty(request('search'))? request('search') : '' }}">
                                <input type="hidden" name="old_subcategory_id" value="{{ !empty($getSubCategory) ? $getSubCategory->id : '' }}">
                                <input type="hidden" name="old_category_id" value="{{ !empty($getCategory) ? $getCategory->id : '' }}">
                                <input type="hidden" name="sub_category_id" id="get_sub_category_id">
                                <input type="hidden" name="price_min" id="price_min">
                                <input type="hidden" name="price_max" id="price_max">
                                <input type="hidden" name="brand_id" id="get_brand_id">
                                <input type="hidden" name="colour_id" id="get_colour_id">
                                <input type="hidden" name="sort_by" id="get_sort_by">

                            </form>
                			<div class="sidebar sidebar-shop">
                				<div class="widget widget-clean">
                					<label>Filters:</label>
                					<a href="#" class="sidebar-filter-clear">Clean All</a>
                				</div><!-- End .widget widget-clean -->

                                @if (!empty($subCategoryFilter))                                   
                               
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title">
                                            <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                                Category
                                            </a>
                                        </h3><!-- End .widget-title -->

                                        <div class="collapse show" id="widget-1">
                                            <div class="widget-body">
                                                <div class="filter-items filter-items-count">
                                                    @foreach ($subCategoryFilter as $filterCategory)
                                                    <div class="filter-item">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input changeCategory" 
                                                            value="{{ $filterCategory->id }}" id="cat-{{ $filterCategory->id }}">
                                                            <label class="custom-control-label" for="cat-{{ $filterCategory->id }}">{{ $filterCategory->name }}</label>
                                                        </div>
                                                        <span class="item-count">{{ $filterCategory->TotalProducts() }}</span>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 @endif

        						<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
									        Colour
									    </a>
									</h3><!-- End .widget-title -->

									<div class="collapse show" id="widget-3">
										<div class="widget-body">
											<div class="filter-colors">
                                                @foreach($getColour as $filterColour)
												<a href="javascript:;" id="{{ $filterColour->id }}" class="changeColour" data-value="0"
                                                style="background:{{ $filterColour->code }};"><span class="sr-only">{{ $filterColour->name }}</span></a>
                                                @endforeach
												
											</div>
                                        </div>
									</div>
        						</div>

        						<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
									        Brand
									    </a>
									</h3><!-- End .widget-title -->

									<div class="collapse show" id="widget-4">
										<div class="widget-body">
											<div class="filter-items">
                                                @foreach ($getBrand as $filterBrand)
                                                    <div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input changeBrand" 
                                                        value="{{ $filterBrand->id }}" id="brand-{{ $filterBrand->id }}">
                                                        <label class="custom-control-label" for="brand-{{ $filterBrand->id }}">{{ $filterBrand->name }}</label>
													</div>
												</div>
                                                @endforeach
											

											</div>
										</div>
									</div>
        						</div>

        						<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
									        Price
									    </a>
									</h3><!-- End .widget-title -->

									<div class="collapse show" id="widget-5">
										<div class="widget-body">
                                            <div class="filter-price">
                                                <div class="filter-price-text">
                                                    Price Range:
                                                    <span id="filter-price-range"></span>
                                                </div>

                                                <div id="price-slider"></div>
                                            </div>
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

@section('script')
<script src="{{ asset('assets/js/wNumb.js') }}"></script>
<script src="{{ asset('assets/js/nouislider.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-input-spinner.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


    $('.changeSortBy').change(function() {
        let sortBy = $(this).val();
        $('#get_sort_by').val(sortBy);
        submitForm();
    });

    $('.changeCategory').change(function() {
        let ids = [];
        $('.changeCategory:checked').each(function() {
            ids.push($(this).val());
        });
        $('#get_sub_category_id').val(ids.join(','));
        submitForm();
    });

    $('.changeBrand').change(function() {
        let ids = [];
        $('.changeBrand:checked').each(function() {
            ids.push($(this).val());
        });
        $('#get_brand_id').val(ids.join(','));
        submitForm();
    });

    $('.changeColour').click(function() {
        let id = $(this).attr('id');
        let value = $(this).data('value');

        if (value == 0) {
            $(this).addClass('active-color');
            $(this).data('value', 1);
        } else {
            $(this).removeClass('active-color');
            $(this).data('value', 0);
        }

        let ids = [];
        $('.changeColour').each(function() {
            if ($(this).data('value') == 1) {
                ids.push($(this).attr('id'));
            }
        });
        $('#get_colour_id').val(ids.join(','));
        submitForm();
    });

    var i = 0;
    var priceMin = @json($priceMin);
    var priceMax = @json($priceMax);
    var selectedPriceMin = @json($selectedPriceMin);
    var selectedPriceMax = @json($selectedPriceMax);

     if ( typeof noUiSlider === 'object' ) {
		var priceSlider  = document.getElementById('price-slider');

		noUiSlider.create(priceSlider, {
			start: [selectedPriceMin, selectedPriceMax],
			connect: true,
			step: 1,
			margin: 1,
			range: {
				'min': priceMin,
				'max': priceMax
			},
			tooltips: true,
			format: wNumb({
		        decimals: 0,
		        prefix: '₦'
		    })
		});

		priceSlider.noUiSlider.on('update', function( values, handle ){
            $('#price_min').val(values[0].replace('₦', '').trim()); 
            $('#price_max').val(values[1].replace('₦', '').trim()); 
			$('#filter-price-range').text(values.join(' - '));
            if (i == 0 || i == 1) {
                i++;
            } else {
                submitForm();
            }
		});
	}

    var xhr;
    function submitForm() {
        if (xhr && xhr.readyState != 4) {
            xhr.abort();
        }
        xhr = $.ajax({
            url: "{{ route('products.filter') }}",
            type: "POST",
            data: $('#filter-form').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#get-product-list').html(response.html);
                } else {
                    console.error('Error in response:', response.message);
                }
            },
       error: function(xhr, status, error) {
    if (status !== 'abort') { 
        console.error('AJAX error:', error);
        alert('An error occurred while submitting the form.');
    }
}
        });
        
    }

    const loadMoreBtn = $('.btn-load-more');
    
    loadMoreBtn.on('click', function() {
        const btn = $(this);
        const page = btn.data('page');
        
        if (!page || btn.hasClass('loading')) return;
        
        btn.addClass('loading');
        
        $.ajax({
            url: "{{ route('products.load-more') }}",
            type: 'POST',
            data: $('#filter-form').serialize() + '&page=' + page,

            success: function(response) {
                if (response.status) {
                    $('#get-product-list').append(response.html);

                    if (response.hasMorePages) {
                        btn.data('page', response.nextPage)
                        .removeClass('d-none loading');
                    } else {
                        btn.remove();
                    }
                }
            },
            error: function(xhr) {
                console.error('Error loading more products:', xhr.responseText);
                btn.removeClass('loading');
            }
        });

    });

});
</script>

@endsection
      
   