@extends('admin.layouts.app')
@section('title', 'Edit Category')
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

<form action="{{ route('categories.update', ['category' => $category->id, 'lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    @method('PUT')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('pages.Edit Category') }}</h4>
                @php
                    $languages = ['en', 'de', 'fr', 'es', 'ar'];
                @endphp

                @foreach ($languages as $lang)
                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.name') }} ({{ strtoupper($lang) }})</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="name_{{ $lang }}" value="{{ old('name_'.$lang, $category->{'name_'.$lang} ?? '') }}">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.desc') }} ({{ strtoupper($lang) }})</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="description_{{ $lang }}" id="desc_{{$lang}}">{{ old('description_'.$lang, $category->{'description_'.$lang} ?? '') }}</textarea>
                        </div>
                    </div>
                @endforeach

                <!-- صورة رئيسية -->
                <div class="form-group">
                    <label for="image">{{ __('messages.product_image') }}</label>
                    <div id="drop-area" class="drop-area">
                        <p>{{ __('messages.drag_drop_image') }}</p>
                        <input type="file" name="image" id="image" class="form-control" style="">
                        <img id="image-preview" src="{{ $category->image ? asset($category->image) : '#' }}" alt="Image Preview" style="{{ $category->image ? '' : 'display: none;' }} margin-top: 10px; max-width: 100%;">
                    </div>
                </div>

                <!-- صور متعددة -->
                <div class="form-group">
                    <label for="multi_images">{{ __('messages.multi_images') }}</label>
                    <input type="file" name="images[]" id="multi_images" class="form-control" multiple>
                    <div id="multi-images-preview" class="multi-images-preview">
                                            @if($category->images)
                                                @foreach(json_decode($category->images) as $image)
                            <img src="{{ asset($image) }}" class="gallery-image">
                        @endforeach
                        @endif
                    </div>
                </div>

                <!-- تحميل ملف كتالوج -->
                <div class="form-group">
                    <label for="catalog">{{ __('messages.upload_catalog') }}</label>
                    <input type="file" name="catalog" id="catalog" class="form-control" accept="application/pdf">
                    @if ($category->catalog)
                        <p id="catalog-name" class="text-muted">تم رفع الملف: <a href="{{ asset($category->catalog) }}" target="_blank">عرض الكتالوج</a></p>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('pages.update') }}</button>
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
    .multi-images-preview img {
        max-width: 100px;
        margin: 5px;
        border-radius: 5px;
    }
</style>
<script>
    // تحميل ومعاينة الصورة الرئيسية
    const imagePreview = document.getElementById('image-preview');
    document.getElementById('image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

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
    
    // تحميل صور متعددة
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

    // تحميل ملف الكتالوج
    const catalogInput = document.getElementById('catalog');
    catalogInput.addEventListener('change', function () {
        document.getElementById('catalog-name').textContent = catalogInput.files.length > 0 ? `تم اختيار الملف: ${catalogInput.files[0].name}` : "";
    });

</script>
<!--tinymce js-->
<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
<!-- init js -->
<script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
@endsection
