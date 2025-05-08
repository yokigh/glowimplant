@extends('user.layout.app')
@section('hero')

    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('user/assets/img/bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{$category->{'name_' . app()->getLocale()} }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{route('products.page', ['lang' => app()->getLocale()])}}">{{ __('messages.Home') }}</a></li>
                    <li>{{$category->{'name_' . app()->getLocale()} }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
<!--==============================
    Service Area
==============================-->
<section class="space-top space-extra-bottom">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-xxl-8 col-lg-8">
                    <div class="page-single single-right mb-30">
                        <div class="page-img">
                            <img src="{{asset($category->image)}}" alt="Service Image">
                        </div>
                        <div class="page-content">
                            <h2 class="page-title">{{ $category->{'name_' . app()->getLocale()} }}</h2>
                            <p class="">{!! $category->{'description_' . app()->getLocale()} !!}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-4">
                    <aside class="sidebar-area">
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">{{ __('messages.Catalog') }}</h3>
                            <ul>
                                <li>
                                    <a href="{{ asset($category->catalog) }}" download>{{ __('messages.Donlowad') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">{{ __('messages.SubCategory') }}</h3>
                            <ul>
                                @foreach ($subcategories as $subcategory)
                                <li>
                                    <a href="{{route('showsubcategory.page', ['lang' => app()->getLocale(), 'subcategory' => $subcategory->id])}}">{{ $subcategory->{'name_' . app()->getLocale()} }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="tab-schedule">
                            <h3 class="widget_title">{{ __('messages.Categories') }}</h3>
                            @foreach ($layoutcategories as $categor)
                                
                            <p class="box-text"><a href="{{route('showcategory.page', ['lang' => app()->getLocale(), 'category' => $categor->id])}}">{{ $categor->{'name_' . app()->getLocale()} }}</a></p>
                            
                            @endforeach
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection