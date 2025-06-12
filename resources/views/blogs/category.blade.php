@extends('layouts.app')

@section('meta_title', $getCategory->meta_title)
@section('meta_description', $getCategory->meta_description)
@section('meta_keywords', $getCategory->meta_keywords)

@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ url('assets/images/page-header-bg.jpg') }}');">
        <div class="container">
            <h1 class="page-title">{{ $getCategory->name }}</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('blogs') }}">Blog</a></li>
                <li class="breadcrumb-item active"><a href="#">{{ $getCategory->name }}</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="entry-container max-col-2" data-layout="fitRows">
                        @foreach ($getBlog as $blog)
                        
                        <div class="entry-item col-sm-6">
                            <article class="entry entry-grid">
                                <figure class="entry-media">
                                    <a href="{{ url('blogs/'.$blog->slug) }}">
                                        <img src="{{ $blog->getImage() }}" style="height: 300px; width: 100%; object-fit: cover;" alt="{{ $blog->title }}">
                                    </a>
                                </figure>

                                <div class="entry-body">
                                    <div class="entry-meta">
                                        <a href="#">{{ date('M d, Y', strtotime($blog->created_at)) }}</a>
                                        <span class="meta-separator">|</span>
                                        <a href="#">{{ $blog->getCommentsCount() }} Comments</a>
                                    </div>

                                    <h2 class="entry-title">
                                        <a href="{{ url('blogs/'.$blog->slug) }}">{{ $blog->title }}</a>
                                    </h2>

                                    @if (!empty($blog->getCategory()))
                                        <div class="entry-cats">
                                            in <a href="{{ url('blog/category/'.$blog->getCategory->slug) }}">{{ $blog->getCategory->name }}</a>
                                        </div>
                                    @endif

                                    <div class="entry-content">
                                        <p>{{ Str::limit(strip_tags($blog->short_description), 150) }}</p>
                                        <a href="{{ url('blogs/'.$blog->slug) }}" class="read-more">Continue Reading <i class="icon-long-arrow-right"></i></a>
                                    </div>

                                </div>
                            </article>
                        </div>
                        @endforeach

                    </div>

                    {!! $getBlog->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                </div><!-- End .col-lg-9 -->

                <aside class="col-lg-3">
                    @include('blogs._sidebar')
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main>

@endsection

@section('script')
@endsection