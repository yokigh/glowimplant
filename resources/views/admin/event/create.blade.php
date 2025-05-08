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
<form action="{{ route('events.store', ['lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('pages.Create Event') }}</h4>
                @php
                    $languages = ['en', 'de', 'fr', 'es', 'ar'];
                @endphp

                @foreach ($languages as $lang)
                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.name') }} ({{ strtoupper($lang) }})</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="name_{{ $lang }}" value="">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.desc') }} ({{ strtoupper($lang) }})</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="desc_{{ $lang }}" name="description_{{ $lang }}"></textarea>
                        </div>
                    </div>
                @endforeach

                <!-- حقل التاريخ -->
                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.event_date') }}</label>
                    <div class="col-md-10">
                        <input type="date" class="form-control" name="event_date" value="{{ old('event_date') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">{{ __('messages.event_image') }}</label>
                    <div id="drop-area" class="drop-area">
                        <p>{{ __('messages.drag_drop_image') }}</p>
                        <input type="file" name="image" id="image" class="form-control" required style="display: none;">
                        <img id="image-preview" src="#" alt="Image Preview" style="display: none; margin-top: 10px; max-width: 100%;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('pages.create_event') }}</button>
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

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add('hover'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove('hover'), false);
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
            const file = files[0];
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

<script src="{{asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-editor.init.js')}}"></script>
@endsection
