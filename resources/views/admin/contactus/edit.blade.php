@extends('admin.layouts.app')
@section('title', __('pages.Edit Contact'))
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

<form action="{{ route('contactus.update', ['contactu' => $contactu->id, 'lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    @method('PUT')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('pages.Edit Contact') }}</h4>

                @php
                    $languages = ['en', 'de', 'fr', 'es', 'ar'];
                @endphp

                @foreach ($languages as $lang)
                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.name') }} ({{ strtoupper($lang) }})</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="name_{{ $lang }}" value="{{ old('name_'.$lang, $contactu->{'name_'.$lang}) }}">
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.desc') }} ({{ strtoupper($lang) }})</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="description_{{ $lang }}" id="desc_{{$lang}}">{{ old('description_'.$lang, $contactu->{'description_'.$lang} ?? '') }}</textarea>
                        </div>
                    </div>
                @endforeach

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.email') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="email" name="email" value="{{ old('email', $contactu->email) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.phone') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="phone" value="{{ old('phone', $contactu->phone) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.country') }}</label>
                    <div class="col-md-10">
                        <select name="country_id" class="form-control">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ isset($contact) && $contact->country_id == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                     </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.address') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="address" value="{{ old('address', $contactu->address) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.map_location') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="map" value="{{ old('map', $contactu->map) }}">
                    </div>
                </div>

                <h4 class="header-title mt-4">{{ __('pages.social_links') }}</h4>

                @php
                    $socialLinks = ['facebook', 'whatsapp', 'instagram', 'tiktok', 'x', 'youtube'];
                @endphp

                @foreach ($socialLinks as $social)
                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.'.$social) }}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="url" name="url_{{ $social }}" value="{{ old('url_'.$social, $contactu->{'url_'.$social}) }}">
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('pages.update_contact') }}</button>
            </div>
        </div>
    </div>
</form>

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
    #image-preview {
        display: none;
        max-width: 100%;
        margin-top: 10px;
    }
</style>

<script>
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
        dropArea.addEventListener(event, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(event => {
        dropArea.addEventListener(event, () => dropArea.classList.add('hover'), false);
    });

    ['dragleave', 'drop'].forEach(event => {
        dropArea.addEventListener(event, () => dropArea.classList.remove('hover'), false);
    });

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
            fileInput.files = files;
            displayImage(files[0]);
        }
    }

    fileInput.addEventListener('change', (e) => {
        displayImage(e.target.files[0]);
    });

    function displayImage(file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
</script>
<!--tinymce js-->
<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
<!-- init js -->
<script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
@endsection
