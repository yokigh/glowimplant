@extends('user.layout.app')
@section('hero')

<!--==============================
Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('user/assets/img/bg.jpg') }}">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ __('messages.payemnt') }}</h1>
            <ul class="breadcumb-menu">
                <li><a href="{{route('home.page', ['lang' => app()->getLocale()])}}">{{ __('messages.Home') }}</a></li>
                <li>{{ __('messages.payemnt') }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection
@section('content')

@endsection