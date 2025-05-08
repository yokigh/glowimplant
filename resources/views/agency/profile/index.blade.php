@extends('agency.layouts.app')
@section('title', __('pages.Edit Profile'))

@section('content')

@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'error',
                title: 'خطأ!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'حسناً'
            });
        });
    </script>
@endif

@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'success',
                title: 'نجاح!',
                text: '{{ session('success') }}',
                confirmButtonText: 'موافق'
            });
        });
    </script>
@endif

<form action="{{ route('agancy.profile.update', ['lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    @method('PUT')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('pages.Edit Profile') }}</h4>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.name') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name='name' value="{{ old('name', $user->name) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.username') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name='username' value="{{ old('username', $user->username) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row" hidden>
                    <label class="col-md-2 col-form-label">{{ __('pages.email') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="email"  name="email" value="{{ old('email', $user->email) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.birth') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="date" name="datebirthday" value="{{ old('datebirthday', $user->datebirthday) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.job') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="job" value="{{ old('job', $user->job) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.phone') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="tel" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.password') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" name="password" type="password" placeholder="********">
                        <small class="text-muted">{{ __('pages.leave_blank_if_not_changing') }}</small>
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.confirm_password') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" name="password_confirmation" type="password" placeholder="********">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.country') }}</label>
                    <div class="col-md-10">
                        <select name="country_id" class="form-control">
                            <option value="">{{ __('pages.Select a country') }}</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.state') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="state" value="{{ old('state', $user->state) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.city') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name='city' value="{{ old('city', $user->city) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.address1') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="address1" value="{{ old('address1', $user->address1) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.address2') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="address2" value="{{ old('address2', $user->address2) }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('pages.update_profile') }}</button>
            </div>
        </div>
    </div>
</form>

@endsection
