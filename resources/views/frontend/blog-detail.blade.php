@extends('frontend.layouts.app')

@section('content')

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Blog Details</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('blogs') }}">Our Blogs</a></li>
                    <li>{{ strlen($blog->title) > 40 ? substr($blog->title, 0, 40) . '...' : $blog->title }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="vs-blog-wrapper blog-details space-top space-extra-bottom">
    <div class="container">
        <div class="row gx-40">
            <div class="col-lg-8">
                <div class="vs-blog blog-single">
                    @if ($blog->image)
                    <div class="blog-img">
                        <img src="{{ url('public/uploads/' . $blog->image) }}" alt="{{ $blog->title }}">
                    </div>
                    @endif

                    <div class="blog-content">
                        <div class="blog-meta">
                            @php
                                $blogDate = $blog->blog_date ?? ($blog->created_at ? \Carbon\Carbon::parse($blog->created_at)->toDateString() : null);
                            @endphp
                            @if ($blogDate)
                            <a href="#"><i class="far fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($blogDate)->format('F j, Y') }}
                            </a>
                            @endif
                        </div>
                        <h2 class="blog-title">{{ $blog->title }}</h2>
                        <div class="blog-full-content">
                            {!! $blog->content !!}
                        </div>
                    </div>

                    <div class="share-links clearfix">
                        <div class="row justify-content-between">
                            <div class="col-xl-auto">
                                <span class="share-links-title">Tags:</span>
                                <div class="tagcloud">
                                    @if ($blog->tags)
                                    @foreach (explode(',', $blog->tags) as $tag)
                                    <a href="{{ url('blogs?search=' . trim($tag)) }}">
                                        {{ trim($tag) }}
                                    </a>
                                    @endforeach
                                    @else
                                    <span>—</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-auto text-xl-end">
                                <span class="share-links-title">Share:</span>
                                <ul class="social-links">
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('blog/' . $blog->slug)) }}" target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url('blog/' . $blog->slug)) }}&text={{ urlencode($blog->title) }}" target="_blank">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url('blog/' . $blog->slug)) }}&title={{ urlencode($blog->title) }}" target="_blank">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if ($prevPost || $nextPost)
                    <div class="blog-navigation row gx-3 mb-4">
                        @if ($prevPost)
                        <div class="col-6">
                            <a href="{{ url('blog/' . $prevPost->slug) }}" class="nav-post nav-prev">
                                <span class="nav-label"><i class="far fa-arrow-left"></i> Previous</span>
                                <span class="nav-title">{{ strlen($prevPost->title) > 50 ? substr($prevPost->title, 0, 50) . '...' : $prevPost->title }}</span>
                            </a>
                        </div>
                        @endif
                        @if ($nextPost)
                        <div class="col-6 text-end">
                            <a href="{{ url('blog/' . $nextPost->slug) }}" class="nav-post nav-next">
                                <span class="nav-label">Next <i class="far fa-arrow-right"></i></span>
                                <span class="nav-title">{{ strlen($nextPost->title) > 50 ? substr($nextPost->title, 0, 50) . '...' : $nextPost->title }}</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if ($relatedPosts->isNotEmpty())
                    <div class="related-posts mb-5">
                        <h2 class="blog-inner-title">Related Posts</h2>
                        <div class="row gx-3">
                            @foreach ($relatedPosts as $related)
                            <div class="col-md-4">
                                <div class="related-post-card">
                                    @if ($related->image)
                                    <a href="{{ url('blog/' . $related->slug) }}">
                                        <img src="{{ url('public/uploads/' . $related->image) }}" alt="{{ $related->title }}" class="w-100">
                                    </a>
                                    @endif
                                    <div class="related-post-body mt-2">
                                        @php
                                            $relatedDate = $related->blog_date ?? ($related->created_at ? \Carbon\Carbon::parse($related->created_at)->toDateString() : null);
                                        @endphp
                                        @if ($relatedDate)
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($relatedDate)->format('M j, Y') }}</span>
                                        @endif
                                        <h5 class="mt-1">
                                            <a href="{{ url('blog/' . $related->slug) }}" class="text-inherit">
                                                {{ strlen($related->title) > 60 ? substr($related->title, 0, 60) . '...' : $related->title }}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                 

                  
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <aside class="sidebar-area">
                    <div class="widget">
                        <h3 class="widget_title">Latest News</h3>
                        <div class="recent-post-wrap">
                            @forelse ($recentPosts as $post)
                            <div class="recent-post">
                                <div class="media-img">
                                    <a href="{{ url('blog/' . $post->slug) }}">
                                        <img src="{{ url('public/uploads/' . $post->image) }}" alt="{{ $post->title }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div class="recent-post-meta">
                                        @php
                                            $postDate = $post->blog_date ?? ($post->created_at ? \Carbon\Carbon::parse($post->created_at)->toDateString() : null);
                                        @endphp
                                        @if ($postDate)
                                        <a href="#"><i class="far fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($postDate)->format('F j, Y') }}
                                        </a>
                                        @endif
                                    </div>
                                    <h4 class="post-title">
                                        <a class="text-inherit" href="{{ url('blog/' . $post->slug) }}">
                                            {{ strlen($post->title) > 50 ? substr($post->title, 0, 50) . '...' : $post->title }}
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            @empty
                            <p>No recent posts.</p>
                            @endforelse
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

<script>
function setReply(commentId, commentName) {
    document.getElementById('parent_id').value = commentId;
    document.getElementById('replyToName').innerText = commentName;
    document.getElementById('replyNotice').style.display = 'block';
    document.getElementById('cancelReplyBtn').style.display = 'inline-block';
    document.querySelector('.vs-comment-form').scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(function() {
        document.querySelector('textarea[name="comment"]').focus();
    }, 500);
}

function clearReply() {
    document.getElementById('parent_id').value = 0;
    document.getElementById('replyNotice').style.display = 'none';
    document.getElementById('cancelReplyBtn').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    clearReply();
});
</script>

<style>
.reply_and_edit { margin-top: 10px; }
.replay-btn { cursor: pointer; color: #007bff; font-size: 14px; transition: all 0.3s; }
.replay-btn:hover { color: #0056b3; text-decoration: underline; }
.replay-btn i { margin-right: 5px; }
.alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
.alert-success { background-color: #d4edda; border-color: #c3e6cb; color: #155724; }
.alert-danger { background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; }
.alert-info { background-color: #d1ecf1; border-color: #bee5eb; color: #0c5460; }
.close { cursor: pointer; font-size: 24px; line-height: 20px; color: #000; opacity: 0.5; }
.close:hover { opacity: 1; }
#cancelReplyBtn { margin-left: 10px; }
.vs-btn.style2 { background-color: #6c757d; color: white; }
.vs-btn.style2:hover { background-color: #5a6268; }
</style>

@endsection
