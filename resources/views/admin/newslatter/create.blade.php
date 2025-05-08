@extends('admin.layouts.app')
@section('title', 'Create Event')
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
<form action="{{ route('store.newslatter', ['lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('pages.Create newslatter') }}</h4>
                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.subject') }} </label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="subject" value="">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.desc') }} </label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                        </div>
                    </div>

                <!-- حقل التاريخ -->
                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.send_date') }}</label>
                    <div class="col-md-10">
                        <input type="date" class="form-control" name="send_date" value="{{ old('send_date') }}">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.send_time') }}</label>
                    <div class="col-md-10">
                        <input type="time" class="form-control" name="send_time" value="{{ old('send_time') }}">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.users_sent') }}</label>
                    <div class="col-md-10">
                        <select class="form-control" name="users_sent" required>
                            <option value="both">{{ __('pages.all_user_subscrip_andjoin') }}</option>
                            <option value="all_subscribers">{{ __('pages.all_user_subscrip') }}</option>
                            <option value="all_users">{{ __('pages.all_user_join') }}</option>
                        </select>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('pages.create_event') }}</button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')

<script src="{{asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-editor.init.js')}}"></script>
@endsection
