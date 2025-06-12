@extends('layouts.app')

@section('meta_title', $getBlog->meta_title)
@section('meta_description', $getBlog->meta_description)
@section('meta_keywords', $getBlog->meta_keywords)

@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ url('assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">{{ $getBlog->title }}</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blogs') }}">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $getBlog->title }}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <article class="entry single-entry">
                        <figure class="entry-media">
                            <img src="{{ $getBlog->getImage() }}" alt="{{ $getBlog->title }}">
                        </figure><!-- End .entry-media -->

                        <div class="entry-body">
                            <div class="entry-meta">
                                <a href="#">{{ date('M d, Y', strtotime($getBlog->created_at)) }}</a>
                                <span class="meta-separator">|</span>
                                <a href="#">{{ $getBlog->getCommentsCount() }} Comments</a>
                                @if (!empty($getBlog->getCategory))
                                    <span class="meta-separator">|</span>
                                    <a href="{{ route('blogs.category', $getBlog->getCategory->slug) }}">{{ $getBlog->getCategory->name }}</a>
                                    
                                @endif
                            </div>
                            <br>

                            <div class="entry-content editor-content">
                                {!! $getBlog->description !!}
                            </div>
                        </div>
                    </article>

                    @if (!empty($getRelatedPost->count()))
                    
                        <div class="related-posts">
                            <h3 class="title">Related Posts</h3>

                            <div class="owl-carousel owl-simple" data-toggle="owl" 
                                data-owl-options='{
                                    "nav": false, 
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":1
                                        },
                                        "480": {
                                            "items":2
                                        },
                                        "768": {
                                            "items":3
                                        }
                                    }
                                }'>
                                @foreach ($getRelatedPost as $related)
                                
                                    <article class="entry entry-grid">
                                        <figure class="entry-media">
                                            <a href="{{ url('blog/'.$related->slug) }}">
                                                <img src="{{ $related->getImage() }}" alt="{{ $related->title }}">
                                            </a>
                                        </figure><!-- End .entry-media -->

                                        <div class="entry-body">
                                            <div class="entry-meta">
                                                <a href="#">{{ $related->created_at->format('M d, Y') }}</a>
                                                <span class="meta-separator">|</span>
                                                <a href="#">{{ $related->getCommentsCount() }} Comments</a>
                                            </div>

                                            <h2 class="entry-title">
                                                <a href="{{ url('blog/'.$related->slug) }}">{{ $related->title }}</a>
                                            </h2>

                                            @if (!empty($related->getCategory))
                                                <div class="entry-cats">
                                                    <a href="{{ route('blogs.category', $related->getCategory->slug) }}">{{ $related->getCategory->name }}</a>
                                                </div>
                                                
                                            @endif
                                        </div>
                                    </article>
                                @endforeach

                            </div>
                        </div>
                    @endif

                    <div class="comments">
                        <h3 class="title">{{ $getBlog->getCommentsCount() }} Comments</h3><!-- End .title -->
                        <ul>
                            <div id="comment-list-wrapper">
                            @foreach ($getBlog->getComments as $comment)
                                
                                <li>
                                    <div class="comment">
                                        <div class="comment-body">
                                            <div class="comment-user">
                                                <h4><a href="#">{{ $comment->user->name }}</a></h4>
                                                <span class="comment-date">{{ date('M d, Y', strtotime($comment->created_at)) }} at {{ date('h:i A', strtotime($comment->created_at)) }}</span>
                                            </div><!-- End .comment-user -->

                                            <div class="comment-content">
                                                <p>{{ $comment->comment }} </p>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                            @endforeach
                            </div>
                        </ul>
                    </div>
                    
                    <div class="reply">
                        <div class="heading">
                            <h3 class="title">Leave A Comment</h3>
                        </div>

                        <form id="blog-comment-form" action="{{ route('blogs.submit.comment') }}" method="post" class="comment-form">
                            @csrf
                            <input type="hidden" name="blog_id" value="{{ $getBlog->id }}">
                            <label for="reply-message" class="sr-only">Comment</label>
                            <textarea name="comment" id="reply-message" cols="30" rows="4" class="form-control" required placeholder="Comment *"></textarea>
                            @if (Auth::check())
                                <button type="submit" class="btn btn-outline-primary-2">
                                    <span>POST COMMENT</span>
                                    <i class="icon-long-arrow-right"></i>
                                </button>
                            @else
                                <a href="#signin-modal" data-toggle="modal" class="btn btn-outline-primary-2">
                                    <span>POST COMMENT</span>
                                    <i class="icon-long-arrow-right"></i>
                                </a>
                            @endif
                            
                        </form>
                    </div>
                </div>

                <aside class="col-lg-3">
                    @include('blogs._sidebar')
                </aside>
            </div>
        </div>
    </div>
</main>

@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {
        $('#blog-comment-form').on('submit', function (e) {
            e.preventDefault();

            const form = $(this);
            const btn = form.find('button[type="submit"]');
            const originalText = btn.html();
            btn.prop('disabled', true).html('<span>Posting...</span>');

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    toastr.success('Your comment has been submitted successfully.');

                    form[0].reset();

                    $('#comment-list-wrapper').load(window.location.href + ' #comment-list-wrapper > *');
                },
                error: function (xhr) {
                    const msg = xhr.responseJSON?.message || 'Comment submission failed.';
                    toastr.error(msg);
                },
                complete: function () {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });

    });
</script>

@endsection