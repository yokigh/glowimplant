@extends('admin.layouts.app')
@section('title', 'Create Prostatic Product')

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

<form action="{{ route('prosthetic_products.store', ['lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('pages.create_prostatic_product') }}</h4>

                @php
                    $languages = ['en', 'de', 'fr', 'es', 'ar'];
                @endphp

                @foreach ($languages as $lang)
                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.name') }} ({{ strtoupper($lang) }})</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name_{{ $lang }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.description') }} ({{ strtoupper($lang) }})</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="desc_{{ $lang }}" name="description_{{ $lang }}"></textarea>
                        </div>
                    </div>
                @endforeach

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.ref') }}</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="ref">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.diameter') }}</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="diameter">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.height') }}</label>
                    <div class="col-md-10">
                        <input type="number" class="form-control" name="height">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.ml') }}</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="ml">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.angle') }}</label>
                    <div class="col-md-10">
                        <input type="number" step="0.01" class="form-control" name="angle">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.screw_ref') }}</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="screw_ref">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.prosthetic_category') }}</label>
                    <div class="col-md-10">
                        <select name="prosthetic_category_id" required>
                            @foreach ($prostheticcategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name_en }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">{{ __('messages.prosthetic_image') }}</label>
                    <div id="drop-area" class="drop-area">
                        <p>{{ __('messages.drag_drop_image') }}</p>
                        <input type="file" name="image" id="image" class="form-control" style="display: none;" >
                        <img id="image-preview" alt="Image Preview" style="display: none; max-width: 100%; margin-top: 10px;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="multi_images">{{ __('messages.prosthetic_images') }}</label>
                    <input type="file" name="images[]" id="multi_images" class="form-control" accept="image/*" multiple>
                    <div id="multi-images-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
                </div>

                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('pages.create_prostatic_product') }}</button>
            </div>
        </div>
    </div>
</form>


@endsection

@section('script')

<!-- Select2 CSS -->
<link href="{{url('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css')}}" rel="stylesheet" />

<!-- Select2 JS -->
<script src="{{url('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Implant",
            allowClear: true,
            width: '100%'
        });
    });
</script>
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
</style>

<script>
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
            fileInput.files = files;
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
            imagePreview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
    
    // صور متعددة
    const multiImagesInput = document.getElementById('multi_images');
    const multiImagesPreview = document.getElementById('multi-images-preview');

    multiImagesInput.addEventListener('change', function () {
        multiImagesPreview.innerHTML = "";
        Array.from(multiImagesInput.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.classList.add("gallery-image");
                multiImagesPreview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

</script>
<!--tinymce js-->
<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
<!-- init js -->
<script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
@endsection
