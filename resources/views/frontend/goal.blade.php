@extends('frontend.layouts.app')


@section('content')



<div class="breadcumb-wrapper " data-bg-src="assets/img/breadcumb/breadcumb-bg.jpg">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Goal </h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Goal </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="space-top space-extra-bottom">
    <div class="container">
        @if($goal->isNotEmpty())
            @foreach($goal as $index => $item)
            <div class="row align-items-center justify-content-between mb-5 
                {{ $index % 2 == 0 ? 'flex-row-reverse' : '' }}">

                {{-- Image --}}
                <div class="col-lg-6 col-xl-auto text-center 
                    {{ $index % 2 == 0 ? 'text-lg-end' : 'text-lg-start' }}">
                    <div class="img-box2">
                        <div class="transform-banner">
                            <img src="{{ url('public/uploads/' . $item->image) }}" alt="about">
                        </div>
                        <div class="vs-circle jump"></div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="col-lg-6 text-center 
                    {{ $index % 2 == 0 ? 'text-lg-start' : 'text-lg-end' }}">
                    {!! $item->name !!}
                </div>

            </div>
            @endforeach

        @else
            {{-- No Data Message --}}
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div style="
                        background: linear-gradient(135deg, #10233f, #173b69);
                        border-radius: 16px;
                        padding: 50px 40px;
                        text-align: center;
                        box-shadow: 0 10px 40px rgba(16, 35, 63, 0.18);
                    ">
                        <div style="font-size: 60px; margin-bottom: 15px;">😔</div>
                        <h3 style="
                            color: #fff;
                            font-size: 24px;
                            font-weight: 700;
                            margin-bottom: 10px;
                            letter-spacing: 0.5px;
                        ">No Goals Found!</h3>
                        <p style="
                            color: rgba(255,255,255,0.85);
                            font-size: 15px;
                            margin: 0;
                            line-height: 1.7;
                        ">Currently there are no goal records available. <br> Please check back later or add data from the admin panel.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>



@endsection