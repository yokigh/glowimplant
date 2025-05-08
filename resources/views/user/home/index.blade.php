@extends('user.layout.app')
@section('title','Home')
@section('hero')
<!--==============================
Hero Area
==============================-->
<div class="th-hero-wrapper hero-1" id="hero" data-bg-src="{{asset('user/assets/img/bg.jpg')}}">
    <div class="swiper th-slider" id="heroSlide1" data-slider-options='{"effect":"fade","autoHeight":true}'>
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
            <div class="swiper-slide">
                <div class="hero-inner">
                    <div class="container">
                        <div class="hero-style1">
                            <span class="hero-subtitle" data-ani="slideinup" data-ani-delay="0.2s">
                                
                            </span>
                            <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.3s">
                               
                            </h1>
                            <h2 class="hero-heading" data-ani="slideinup" data-ani-delay="0.4s">
                               Glow Implant
                            </h2>
                            <p class="hero-text" data-ani="slideinup" data-ani-delay="0.5s">
                                
                            </p>
                            <a href="{{route('products.page', ['lang' => app()->getLocale()])}}" class="th-btn style4" data-ani="slideinup" data-ani-delay="0.6s">
                                <i class="fas fa-shopping-cart me-2"></i>{{ __('messages.Shop Now') }}
                            </a>
                        </div>
                    </div>
                    <div class="hero-img" data-ani="slideinright" data-ani-delay="0.5s">
                        <img src="{{ asset($slider->image) }}" alt="Image">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="hero-thumb-wrap">
        <div class="hero-thumb" data-slider-tab="#heroSlide1">
            @foreach($sliders as $slider)
            <div class="tab-btn {{ $loop->first ? 'active' : '' }}">
                <img src="{{ asset($slider->image) }}" alt="Image">
            </div>
            @endforeach
        </div>
    </div>
</div>
<!--======== / Hero Section ========-->

@endsection
@section('content')

    <!--==============================
Feature Area  
==============================-->
<section class="space">
        <div class="container">
            <div class="feature-list-wrap">
            @foreach ($layoutcategories as $category)

                <div class="feature-list">
                    <div class="box-icon">
                        <img src="{{asset($category->image)}}" alt="icon">
                    </div>
                    <div class="media-body">
                        <a href="{{route('showcategory.page', ['lang' => app()->getLocale(), 'category' => $category->id])}}" class="box-title">{{ $category->{'name_' . app()->getLocale()} }}</a>
                    </div>
                </div>
                <div class="feature-list-line"></div>
            @endforeach
            </div>
        </div>
    </section>
    <!--==============================
Category Area  
==============================-->
    <section class="space-top">
        <div class="container">
            <div class="row justify-content-md-between justify-content-center align-items-center">
                <div class="col-md-auto">
                    <h3 class="sec-title text-center">{{ __('messages.Shop by SubCategory') }}</h3>
                </div>
                <div class="col-md-auto mt-n3 mt-md-0">
                    <div class="sec-btn">
                        <div class="icon-box">
                            <button data-slider-prev="#catSlide1" class="slider-arrow icon-sm default"><i class="far fa-arrow-left"></i></button>
                            <button data-slider-next="#catSlide1" class="slider-arrow icon-sm default"><i class="far fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper th-slider" id="catSlide1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"400":{"slidesPerView":"2"},"768":{"slidesPerView":"4"},"992":{"slidesPerView":"5"},"1200":{"slidesPerView":"6"}}}'>
                <div class="swiper-wrapper">
                    @foreach ($sub_categries as $subcategory)
                        
                    <div class="swiper-slide">
                        <div class="category-card">
                            <div class="box-icon">
                                <img src="{{asset($subcategory->image)}}" alt="Image">
                            </div>
                            <h3 class="box-title"><a href="{{route('showsubcategory.page', ['lang' => app()->getLocale(), 'subcategory' => $subcategory->id])}}">{{ $subcategory->{'name_' . app()->getLocale()} }}</a></h3>
                        </div>
                    </div>

                    @endforeach

                </div>
            </div>
        </div>
    </section>
    <!--==============================
Cta Area  
==============================-->
@if($latestAbout)
    <section class="overflow-hidden ">
        <div class="container-fluid px-xl-0 z-index-common">
            <div class="row gy-30">
                <div class="col-xl-8">
                    <div class="offer-block mega-hover" data-bg-src="{{asset($latestAbout->image)}}">
                        <span class="h6 box-subtitle text-black">Glow Impant</span>
                        <p class="box-text text-black">{!! $latestAbout->{'description_' . app()->getLocale()} !!}</p>
                        <a href="{{route('products.page', ['lang' => app()->getLocale()])}}" class="th-btn">{{ __('messages.Shop Now') }}</a>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="offer-block2 mega-hover" data-bg-src="{{asset('user/assets/img/bg.jpg')}}">
                        <h3 class="sec-title">{{ $latestAbout->{'name_' . app()->getLocale()} }}</h3>
                        <a href="{{route('products.page', ['lang' => app()->getLocale()])}}" class="th-btn style4">{{ __('messages.Shop Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection