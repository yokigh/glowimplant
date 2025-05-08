@extends('user.layout.app')
@section('hero')

    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('user/assets/img/bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Events</h1>
                <ul class="breadcumb-menu">
                    <li><a href="home-medical-clinic.html">Home</a></li>
                    <li>Events</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
  <!--==============================
Achievement Area  
==============================-->
<section class="space" id="achieve-sec">
    <div class="container">
        <div class="title-area text-center text-md-start">
            <span class="sub-title">
                <img src="{{ asset('assets/images/logo/glow.png') }}" style="width:84px;" alt="shape">Event
            </span>
            <h2 class="sec-title">See all Our Events</h2>
        </div>
        <div class="achieve-box-wrap">
            @if(isset($events) && $events->count() > 0)
                @foreach($events as $event)
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
                <p class="text-center">No Event Now</p>
            @endif
        </div>
    </div>
</section>

@endsection