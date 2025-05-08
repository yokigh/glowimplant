@extends('user.layout.app')
@section('hero')

    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('user/assets/img/bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{$subcategory->{'name_' . app()->getLocale()} }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{route('home.page', ['lang' => app()->getLocale()])}}">{{ __('messages.Home') }}</a></li>
                    <li><a href="{{route('showcategory.page', ['lang' => app()->getLocale(), 'category' => $subcategory->category->id])}}">{{ $subcategory->category ? $subcategory->category->{'name_' . app()->getLocale()} : '-' }}</a></li>
                    <li>{{$subcategory->{'name_' . app()->getLocale()} }}</li>
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
                            <img src="{{asset($subcategory->image)}}" alt="Service Image">
                        </div>
                        <div class="page-content">
                            <h2 class="page-title">{{ $subcategory->{'name_' . app()->getLocale()} }}</h2>
                            <p class="">{!! $subcategory->{'description_' . app()->getLocale()} !!}</p>
                            
                            <div class="sec-btn">
                                <a href="{{route('showsubcategoryproduct.page', ['lang' => app()->getLocale(), 'subcategory' => $subcategory->id])}}" class="th-btn style4">{{ __('messages.View All Product') }}</a>
                            </div>
                            <div class="accordion mt-40" id="faqAccordion">


                                <div class="accordion-card">
                                    <div class="accordion-header" id="collapse-item-1">
                                        <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1">{{ __('messages.benefits') }}</button>
                                    </div>
                                    <div id="collapse-1" class="accordion-collapse collapse show" aria-labelledby="collapse-item-1" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">{!! $subcategory->{'benefits_' . app()->getLocale()} !!}</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="accordion-card">
                                    <div class="accordion-header" id="collapse-item-2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">{{ __('messages.technical_info') }}</button>
                                    </div>
                                    <div id="collapse-2" class="accordion-collapse collapse " aria-labelledby="collapse-item-2" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">{!! $subcategory->{'technical_info_' . app()->getLocale()} !!}</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="accordion-card">
                                    <div class="accordion-header" id="collapse-item-3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">{{ __('messages.clinical_cases') }}</button>
                                    </div>
                                    <div id="collapse-3" class="accordion-collapse collapse " aria-labelledby="collapse-item-3" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">{!! $subcategory->{'clinical_cases_' . app()->getLocale()} !!}</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="accordion-card">
                                    <div class="accordion-header" id="collapse-item-4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-4" aria-expanded="false" aria-controls="collapse-4">{{ __('messages.publish_articles') }}</button>
                                    </div>
                                    <div id="collapse-4" class="accordion-collapse collapse " aria-labelledby="collapse-item-4" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">{!! $subcategory->{'publish_articles_' . app()->getLocale()} !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-4">
                    <aside class="sidebar-area">
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">Catalog</h3>
                            <ul>
                                <li>
                                    <a href="{{ asset($subcategory->catalog) }}" download>{{ __('messages.Donlowad') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-schedule">
                            <h3 class="widget_title">{{ __('messages.Categories') }}</h3>
                            @foreach ($layoutcategories as $categor)
                                
                            <p class="box-text"><a href="{{route('showcategory.page', ['lang' => app()->getLocale(), 'category' => $categor->id])}}">{{ $categor->{'name_' . app()->getLocale()} }}</a></p>
                            
                            @endforeach
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
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection