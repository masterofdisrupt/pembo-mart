<div class="products">
    @php
        $is_home = 1; 
    @endphp
    @include('products._list')
</div>
    <div class="more-container text-center">
    <a href="{{ url($getCategory->slug) }}" class="btn btn-outline-darker btn-more"><span>Load more products</span><i class="icon-long-arrow-down"></i></a>
</div>