@extends('frontend.layouts.app')

@section('content')

<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Cancellation & Refund</h1>
            <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Cancellation & Refund</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="space">
    <div class="container">
        @if($cancellation_refund->count() > 0)
        @foreach($cancellation_refund as $cancellation)
        <div class="mb-4">
            {!! $cancellation->name !!}
        </div>
        @if(!$loop->last)
        <hr>
        @endif
        @endforeach
        @else

        <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div style="
                        background: linear-gradient(135deg, #10233f, #173b69);
                        border-radius: 16px;
                        padding: 27px 40px;
                        text-align: center;
                        box-shadow: 0 10px 40px rgba(16, 35, 63, 0.18);
                        margin-top: -68px;
                    ">
                        <div style="font-size: 60px; margin-bottom: 15px;">😔</div>
                        <h3 style="
                            color: #fff;
                            font-size: 24px;
                            font-weight: 700;
                            margin-bottom: 10px;
                            letter-spacing: 0.5px;
                        ">No cancellation refund content Found!</h3>
                        
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@endsection