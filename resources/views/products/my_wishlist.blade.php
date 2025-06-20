@extends('layouts.app') 

@section('meta_title', $meta_title)
@section('meta_description', $meta_description)
@section('meta_keywords', $meta_keywords)

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
                    <h1 class="page-title">My Wishlist</h1>               
        		</div>
        	</div>
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">My Wishlist</a></li>
                       
                    </ol>
                </div>
            </nav>

            <div class="page-content">
                <div class="container">
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="toolbox">
                				<div class="toolbox-left">
                					<div class="toolbox-info">
                                        Showing <span>{{ $getProduct->firstItem() }} - {{ $getProduct->lastItem() }}</span> 
                                        of {{ $getProduct->total() }} Products
                                    </div>
                		        </div>
                			</div>
                                @include('products._list')                    
                		</div>
                        <div class="col-lg-12">
                            {!! $getProduct->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                        </div>
                	</div>
                </div>
            </div>
        </main>
@endsection

@section('script')
@endsection
      
   