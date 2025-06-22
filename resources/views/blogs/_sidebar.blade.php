<div class="sidebar">
    <div class="widget widget-search">
        <h3 class="widget-title">Search</h3><!-- End .widget-title -->

        <form action="{{ route('blogs') }}" method="get" class="input-wrapper input-wrapper-inline">
            <label for="ws" class="sr-only">Search in blog</label>
            <input type="text" class="form-control" value="{{ Request::get('search') }}" name="search" id="ws" placeholder="Search in blog">
            <button type="submit" class="btn"><i class="icon-search"></i><span class="sr-only">Search</span></button>
        </form>
    </div><!-- End .widget -->

    <div class="widget widget-cats">
        <h3 class="widget-title">Categories</h3><!-- End .widget-title -->

        <ul>
            @foreach ($getBlogCategory as $category)
                
            <li><a href="{{ url('blog/category/'.$category->slug) }}">{{ $category->name }}<span>{{ $category->getBlogcount() }}</span></a></li>
            @endforeach
        </ul>
    </div><!-- End .widget -->

    <div class="widget">
        <h3 class="widget-title">Popular Posts</h3>

        <ul class="posts-list">
            @foreach ($getPopular as $popular)
            <li>
                <figure>
                    <a href="{{ url('blog/'.$popular->slug) }}">
                        <img src="{{ $popular->getImage() }}" alt="{{ $popular->title }}" width="80" height="80">
                    </a>
                </figure>

                <div>
                    <span>{{ $popular->created_at->format('M d, Y') }}</span>
                    <h4><a href="{{ url('blog/'.$popular->slug) }}">{{ $popular->title }}</a></h4>
                </div>
            </li>
                
            @endforeach
        </ul>
    </div>

</div>