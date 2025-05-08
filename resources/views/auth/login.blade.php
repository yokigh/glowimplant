@extends('layouts.app')
@section('title',__('titles.Login Glowimplant'))
@section('content')
<style>
    @keyframes fadeInScale {
    0% {
        opacity: 0;
        transform: scale(0.8);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.logo img {
    animation: fadeInScale 1s ease-in-out;
}
.logo img {
    transition: transform 0.3s ease-in-out;
}

.logo img:hover {
    transform: scale(1.1);
}

</style>
<div class="home-btn d-none d-sm-block">
            <a href="index.html"><i class="mdi mdi-home-variant h2 text-white"></i></a>
        </div>

        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-xl-5 col-sm-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="p-2">
                                    
                                <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-center mb-5">
                                                <a href="index.html" class="logo"><img src="{{asset('assets/images/logo/logo.png')}}" height="24" alt="logo"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mb-5 text-center">{{ __('pages.Sign in to continue to Glow Implant') }}.</h5>
                                    <form class="form-horizontal" method="POST" action="{{ route('login', ['lang' => app()->getLocale()]) }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group form-group-custom mb-4">
                                                    <input type="email" class="form-control" name="email" id="email" required>
                                                    <label for="email">{{ __('pages.Email') }}</label>
                                                </div>

                                                <div class="form-group form-group-custom mb-4">
                                                    <input type="password" class="form-control" name="password" id="userpassword" required>
                                                    <label for="userpassword">{{ __('pages.Password') }}</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                            <label class="custom-control-label" for="customControlInline">{{ __('pages.Remember me') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="text-md-right mt-3 mt-md-0">
                                                            <a href="{{ route('password.request', ['lang' => app()->getLocale()]) }}" class="text-muted"><i class="mdi mdi-lock"></i> {{ __('pages.Forgot your password') }}?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <button class="btn btn-success d-block w-100 waves-effect waves-light" type="submit">{{ __('pages.Log In') }}</button>
                                                </div>
                                                <div class="mt-4 text-center">
                                                    <a href="{{ route('register', ['lang' => app()->getLocale()]) }}" class="text-muted"><i class="mdi mdi-account-circle me-1"></i>{{ __('pages.Create an account') }} </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end Account pages -->
         @endsection