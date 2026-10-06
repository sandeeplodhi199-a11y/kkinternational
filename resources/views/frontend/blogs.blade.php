@extends('frontend.layouts.app')

@section('content')

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Our Blogs</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Our Blogs</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- ==============================
     Blog Area
     ============================== --}}
<section class="vs-blog-wrapper space-top space-extra-bottom">
    <div class="container">
        <div class="row gx-40">

            {{-- ===================== MAIN BLOG COLUMN ===================== --}}
            <div class="col-lg-8">

                @forelse ($blogs as $blog)
                <div class="vs-blog blog-single {{ $blog->image ? 'has-post-thumbnail' : '' }}">

                    {{-- Blog image (only when present) --}}
                    @if ($blog->image)
                    <div class="blog-img">
                        <a href="{{ url('blog/' . $blog->slug) }}">
                            <img src="{{ url('public/uploads/' . $blog->image) }}" alt="{{ $blog->title }}">
                        </a>
                    </div>
                    @endif

                    <div class="blog-content">
                        <div class="blog-meta">
                            @php
                                $blogDate = $blog->blog_date ?? ($blog->created_at ? \Carbon\Carbon::parse($blog->created_at)->toDateString() : null);
                            @endphp
                            @if ($blogDate)
                            <a href="#"><i class="far fa-calendar-alt"></i>{{ \Carbon\Carbon::parse($blogDate)->format('F j, Y') }}</a>
                            @endif
                        </div>

                        <h2 class="blog-title">
                            <a href="{{ url('blog/' . $blog->slug) }}">{{ $blog->title }}</a>
                        </h2>

                        <p class="blog-text">{{ $blog->short_content }}</p>

                        {{-- Tags --}}
                        @if ($blog->tags)
                        <div class="blog-tags mb-3">
                            @foreach (explode(',', $blog->tags) as $tag)
                                <a href="{{ url('blogs?search=' . trim($tag)) }}" class="tag-link">
                                    <i class="far fa-tag"></i>{{ trim($tag) }}
                                </a>
                            @endforeach
                        </div>
                        @endif

                        <a href="{{ url('blog/' . $blog->slug) }}" class="vs-btn style2">Read More</a>
                    </div>
                </div>
                @empty
                <div class="alert alert-info">
                    No blog posts found{{ $search ? ' for "' . e($search) . '"' : '' }}.
                </div>
                @endforelse

                {{-- ===== Pagination ===== --}}
                @if ($blogs->hasPages())
                <div class="vs-pagination">
                    {{-- Prev --}}
                    @if ($blogs->onFirstPage())
                        <span class="pagi-btn disabled">Prev</span>
                    @else
                        <a href="{{ $blogs->previousPageUrl() }}" class="pagi-btn">Prev</a>
                    @endif

                    <ul>
                        @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                            <li>
                                <a href="{{ $url }}"
                                   class="{{ $page == $blogs->currentPage() ? 'active' : '' }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Next --}}
                    @if ($blogs->hasMorePages())
                        <a href="{{ $blogs->nextPageUrl() }}" class="pagi-btn">Next</a>
                    @else
                        <span class="pagi-btn disabled">Next</span>
                    @endif
                </div>
                @endif

            </div>{{-- /col-lg-8 --}}

            {{-- ===================== SIDEBAR ===================== --}}
            <div class="col-lg-4">
                <aside class="sidebar-area">

                    {{-- Latest News Widget --}}
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
                                            {{ \Illuminate\Support\Str::limit($post->title, 50) }}
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            @empty
                            <p>No recent posts.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- CTA Widget --}}
                    <div class="widget bg-vs-secondary"
                         data-bg-src="{{ url('assets/frontend/img/bg/widget-bg-1-1.png') }}">
                        <h4 class="mt-n2 text-white">Join together to make amazing things happen</h4>
                        <p class="mb-4 pb-1 text-white">
                            Get all the latest information, support and guidance about
                            the cost of living with kindergarten.
                        </p>
                        <a href="#" class="vs-btn">Start Registration</a>
                    </div>

                </aside>
            </div>{{-- /col-lg-4 --}}

        </div>
    </div>
</section>

@endsection
