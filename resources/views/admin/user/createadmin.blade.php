@extends('admin.layouts.app')
@section('title','Create User')
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

<form action="{{ route('user.store', ['lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('pages.Create User') }}</h4>
                <div class="form-group mb-3 row">
                    <label for="example-text-input" class="col-md-2 col-form-label">{{ __('pages.name') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name='name' value="" id="example-text-input">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="username-text-input" class="col-md-2 col-form-label">{{ __('pages.username') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name='username' value="" id="username-text-input">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="example-search-input" class="col-md-2 col-form-label">{{ __('pages.email') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="email" name="email" value="" id="example-search-input">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="example-url-input" class="col-md-2 col-form-label">{{ __('pages.birth') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="date" name="datebirthday" value="" id="example-url-input">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="example-job-input" class="col-md-2 col-form-label">{{ __('pages.job') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="job" value="" id="example-job-input">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="example-tel-input" class="col-md-2 col-form-label">{{ __('pages.phone') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="tel" name="phone" value="" id="example-tel-input">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="example-password-input" class="col-md-2 col-form-label">{{ __('pages.password') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" name="password" type="password" value="" id="example-password-input">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="example-confirm_password-input" class="col-md-2 col-form-label">{{ __('pages.confirm_password') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" name="password_confirmation" type="password" value="" id="example-confirm_password-input">
                    </div>
                </div>
                
                <div class="form-group mb-3 row">
                    <label for="example-number-input" class="col-md-2 col-form-label">{{ __('pages.country') }}</label>
                    <div class="col-md-10">
                    <select id="country" name="country_id" class="form-control" required>
                                        <option value="">{{ __('pages.Select a country') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="example-datetime-local-input" class="col-md-2 col-form-label">{{ __('pages.state') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="state" value="" id="example-datetime-local-input">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="example-date-input" class="col-md-2 col-form-label">{{ __('pages.city') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name='city' value="" id="example-date-input">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="example-month-input" class="col-md-2 col-form-label">{{ __('pages.zipcode') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" name="zipcode" value="" id="example-month-input">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="example-week-input" class="col-md-2 col-form-label">{{ __('pages.address1') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="" name="address1" id="example-week-input">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="example-time-input" class="col-md-2 col-form-label">{{ __('pages.address1') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="" name="address1" id="example-time-input">
                    </div>
                </div>
                <div class="form-group mb-3 row">
                    <label for="example-color-input" class="col-md-2 col-form-label">{{ __('pages.address2') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="" name="address2" id="example-color-input">
                    </div>
                </div>
                <input type="text" value="admin" name="role" hidden>
                
                <div class="form-group">
                            <label for="image">{{ __('messages.product_image') }}</label>
                            <div id="drop-area" class="drop-area">
                                <p>{{ __('messages.drag_drop_image') }}</p>
                                <input type="file" name="image" id="image" class="form-control" required style="display: none;">
                                <img id="image-preview" src="#" alt="Image Preview" style="display: none; margin-top: 10px; max-width: 100%;">
                            </div>
                        </div>
                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('pages.create_admin') }}</button>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>
@endsection
@section('script')

<style>
    .drop-area {
        border: 2px dashed #ccc;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        margin-top: 10px;
    }
    .drop-area.hover {
        border-color: #333;
    }
    .gallery-image {
        display: inline-block;
        margin: 5px;
        max-width: 100px;
        max-height: 100px;
    }
</style>

<script>
    // Handle single image upload
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add('hover'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove('hover'), false);
    });

    // Handle dropped files
    dropArea.addEventListener('drop', handleDrop, false);
    dropArea.addEventListener('click', () => fileInput.click());

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        if (files.length) {
            const file = files[0];
            // Update the file input with the dropped file
            fileInput.files = files; // This line ensures the dropped file is set
            displayImage(file);
        }
    }

    fileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            displayImage(file);
        }
    });

    function displayImage(file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block'; // Show the image
        }
        reader.readAsDataURL(file);
    }

</script>
@endsection