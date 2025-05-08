@extends('user.layout.app')
@section('hero')

    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('user/assets/img/bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ __('messages.About Us') }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{route('home.page', ['lang' => app()->getLocale()])}}">{{ __('messages.Home') }}</a></li>
                    <li>{{ __('messages.About Us') }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!--==============================
About Area  
==============================-->

<div class="overflow-hidden space" id="about-sec">
        <div class="shape-mockup" data-top="0" data-right="0"><img src="{{asset('user/assets/img/shape/pattern_shape_1.png')}}" alt="shape"></div>
        <div class="shape-mockup jump d-none d-xl-none" data-bottom="10%" data-left="2%"><img src="{{asset('user/assets/img/shape/medicine_1.png')}}" alt="shape"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-8">
                    <div class="title-area text-center">
                        <span class="sub-title"><img src="{{asset('assets/images/logo/glow.png')}}" alt="shape">{{ __('messages.About Our Glow Implant') }}</span>
                        <h2 class="sec-title">{{ $latestAbout->{'name_' . app()->getLocale()} }}</h2>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-xl-6 mb-30 mb-xl-0">
                    <div class="img-box1">
                        <div class="img1">
                            <img src="{{ asset($latestAbout->image) }}" alt="About">
                        </div>
                        <div class="about-info style2">
                            <h3 class="box-title">{{ $firstcontactUs->{'name_' . app()->getLocale()} }}</h3>
                            <p class="box-text">{{ $firstcontactUs->email }}</p>
                            <div class="box-review">
<hr>                            </div>
                            <a href="tel:{{ $firstcontactUs->phone }}" class="box-link"><i class="fa-solid fa-phone"></i> {{ $firstcontactUs->phone }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="ps-xxl-4 ms-xl-2 text-center text-xl-start">
                        <div class="title-area mb-32">
                            <p class="sec-text mt-n2">{!! $latestAbout->{'description_' . app()->getLocale()} !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
Counter Area  
==============================-->
<div class="z-index-common" data-pos-for="#why-sec" data-sec-pos="bottom-half">
    <div class="container">
        <div class="counter-card-wrap bg-theme2">
            <div class="counter-card">
                <h2 class="box-number text-white">
                    <span class="number"><span class="counter-number">{{ $categoryCount }}</span></span><span class="plus">+</span>
                </h2>
                <p class="box-text text-white">{{ __('messages.Total Categories') }}</p>
            </div>
            <div class="divider"></div>
            <div class="counter-card">
                <h2 class="box-number text-white">
                    <span class="number"><span class="counter-number">{{ $subCategoryCount }}</span></span><span class="plus">+</span>
                </h2>
                <p class="box-text text-white">{{ __('messages.Total Subcategories') }}</p>
            </div>
            <div class="divider"></div>
            <div class="counter-card">
                <h2 class="box-number text-white">
                    <span class="number"><span class="counter-number">{{ $paymentCount }}</span></span><span class="plus">+</span>
                </h2>
                <p class="box-text text-white">{{ __('messages.Total Payments') }}</p>
            </div>
            <div class="divider"></div>
            <div class="counter-card">
                <h2 class="box-number text-white">
                    <span class="number"><span class="counter-number">{{ $productCount }}</span></span><span class="plus">+</span>
                </h2>
                <p class="box-text text-white">{{ __('messages.Total Products') }}</p>
            </div>
            <div class="divider"></div>
        </div>
    </div>
</div>

    <!--==============================
Achievement Area  
==============================-->
<section class="space" id="achieve-sec">
    <div class="container">
        <div class="title-area text-center text-md-start">
            <span class="sub-title">
                <img src="{{ asset('assets/images/logo/glow.png') }}" style="width:84px;" alt="shape">Event
            </span>
            <h2 class="sec-title">{{ __('messages.See all Our Events') }}</h2>
        </div>
        <div class="achieve-box-wrap">
            @if(isset($latestEvents) && $latestEvents->count() > 0)
                @foreach($latestEvents as $event)
                    <div class="achieve-box hover-item">
                        <div class="box-img">
                            <img src="{{ asset($event->image) }}" alt="{{ $event->{'name_' . app()->getLocale()} }}" style="width:222px;height:222px;">
                        </div>
                        <div class="box-year">{{ \Carbon\Carbon::parse($event->created_at)->format('Y') }}</div>
                        <div class="media-body">
                            <h3 class="box-title">{{ $event->{'name_' . app()->getLocale()} }}</h3>
                            <p class="box-text">{!! Str::limit($event->{'description_' . app()->getLocale()}, 100) !!}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">{{ __('messages.No Event Now') }}</p>
            @endif
        </div>
    </div>
</section>

@endsection