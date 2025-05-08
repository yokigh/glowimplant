@extends('layouts.app')
@section('title', __('titles.Create Your Account'))
@section('content')
<div class="home-btn d-none d-sm-block">
        <a href=""><i class="mdi mdi-home-variant h2 text-white"></i></a>
    </div>

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-sm-8">
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                            <a href="index.html" class="logo"><img src="{{asset('assets/images/logo/logo.png')}}" height="24" alt="logo"></a>

                                <h5 class="font-size-16 text-muted mt-3">{{ __('pages.Create Your Account') }}</h5>
                            </div>

                            <form method="POST" action="{{ route('register', ['lang' => app()->getLocale()]) }}">
                                @csrf
                                <div class="form-group form-group-custom mb-4">
                                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                                    <label for="name">{{ __('pages.Full Name') }}</label>
                                </div>

                                <div class="form-group form-group-custom mb-4">
                                    <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                                    <label for="email">{{ __('pages.Email') }}</label>
                                </div>

                                <div class="form-group form-group-custom mb-4">
                                    <input type="text" class="form-control" id="username" name="username" required value="{{ old('username') }}">
                                    <label for="username">{{ __('pages.username') }}</label>
                                </div>

                                <div class="form-group form-group-custom mb-4">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <label for="password">{{ __('pages.Password') }}</label>
                                </div>

                                <div class="form-group form-group-custom mb-4">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    <label for="password_confirmation">{{ __('pages.Confirm Password') }}</label>
                                </div>

                                <div class="form-group form-group-custom mb-4">
                                    <input type="date" class="form-control" id="datebirthday" name="datebirthday" required value="{{ old('datebirthday') }}">
                                    <label for="datebirthday">{{ __('pages.Date of Birth') }}</label>
                                </div>

                                <div class="form-group form-group-custom mb-4">
                                    <input type="text" class="form-control" id="job" name="job" required value="{{ old('job') }}">
                                    <label for="job">{{ __('pages.Job') }}</label>
                                </div>

                                <div class="form-group form-group-custom mb-4">
                                    <select id="country" name="country_id" class="form-control" required>
                                        <option value="">{{ __('pages.Select a country') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="country">{{ __('pages.Country') }}</label>
                                </div>
                                <div class="form-group form-group-custom mb-4">
                                    <input type="text" class="form-control" id="State" name="state" required value="{{ old('state') }}">
                                    <label for="State">{{ __('pages.State') }}</label>
                                </div>
                                <div class="form-group form-group-custom mb-4">
                                    <input type="text" class="form-control" id="city" name="city" required value="{{ old('city') }}">
                                    <label for="city">{{ __('pages.city') }}</label>
                                </div>
                                <div class="form-group form-group-custom mb-4">
                                    <input type="number" class="form-control" id="zipcode" name="zipcode" required value="{{ old('zipcode') }}">
                                    <label for="zipcode">{{ __('pages.zipcode') }}</label>
                                </div>
                                <div class="form-group form-group-custom mb-4">
                                    <input type="text" class="form-control" id="address1" name="address1" required value="{{ old('address1') }}">
                                    <label for="address1">{{ __('pages.address1') }}</label>
                                </div>
                                <div class="form-group form-group-custom mb-4">
                                    <input type="text" class="form-control" id="address2" name="address2" required value="{{ old('address2') }}">
                                    <label for="address2">{{ __('pages.address2') }}</label>
                                </div>
                                <div class="form-group form-group-custom mb-4">
                                    <input type="phone" class="form-control" id="phone" name="phone" required value="{{ old('phone') }}">
                                    <label for="phone">{{ __('pages.phone') }}</label>
                                </div>

                                <input type="hidden" name="role" value="user">

                                <div class="mt-4">
                                    <button class="btn btn-success d-block w-100 waves-effect waves-light" type="submit">{{ __('pages.Register') }}</button>
                                </div>

                                <div class="mt-4 text-center">
                                    <a href="{{ route('login', ['lang' => app()->getLocale()]) }}" class="text-muted">
                                        <i class="mdi mdi-account-circle me-1"></i> {{ __('pages.Already have an account') }}
                                    </a>
                                </div>
                            </form>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection