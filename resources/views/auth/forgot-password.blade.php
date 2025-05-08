@extends('layouts.app')
@section('title',__('titles.Forget Password'))
@section('content')

<div class="home-btn d-none d-sm-block">
            <a href="index.html"><i class="mdi mdi-home-variant h2 text-white"></i></a>
        </div>

        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-sm-8">
                        <div class="card">
                            <div class="card-body p-4">
                            <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-center mb-5">
                                                <a href="index.html" class="logo"><img src="{{asset('assets/images/logo/logo.png')}}" height="24" alt="logo"></a>
                                            </div>
                                        </div>
                                    </div>
                                <div class="p-2">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <h5 class="mb-5 text-center">{{ __('pages.Reset Password') }}</h5>
                                    <form class="form-horizontal" method="POST" action="{{ route('password.email', ['lang' => app()->getLocale()]) }}">
                                    @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                {{ __('pages.text_enter_email') }}
                                                    
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <span class="mdi mdi-close"></span>
                                                    </button>
                                                </div>

                                                <div class="form-group form-group-custom mt-5">
                                                    <input type="email" class="form-control" id="email" name="email" required>
                                                    <label for="email">{{ __('pages.Email') }}</label>
                                                </div>
                                                <div class="mt-4">
                                                    <button class="btn btn-success d-block w-100 waves-effect waves-light" type="submit">{{ __('pages.Send Email') }}</button>
                                                </div>
                                                <div class="mt-4 text-center">
                                                    <a href="{{route('login', ['lang' => app()->getLocale()])}}" class="text-muted"><i class="mdi mdi-account-circle me-1"></i> {{ __('pages.Log In') }}</a>
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