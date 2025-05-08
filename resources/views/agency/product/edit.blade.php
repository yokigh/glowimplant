@extends('agency.layouts.app')
@section('title', 'Edit Product')
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

<form action="{{ route('agencyproducts.update', ['lang' => app()->getLocale(), 'product' => $product->id]) }}" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    @method('PUT')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('pages.Edit Product') }}</h4>
                @php
                    $languages = ['en', 'de', 'fr', 'es', 'ar'];
                @endphp
                
                @foreach ($languages as $lang)
                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.desc') }} ({{ strtoupper($lang) }})</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="desc_{{ $lang }}" name="description_{{ $lang }}">{{ old('description_'.$lang, $product->{'description_'.$lang}) }}</textarea>
                        </div>
                    </div>
                @endforeach
                
                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">REF</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="ref" value="{{ old('ref', $product->ref) }}">
                    </div>
                </div>
                
                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">Diameter</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="diameter" value="{{ old('diameter', $product->diameter) }}">
                    </div>
                </div>
                
                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">Height</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="height" value="{{ old('height', $product->height) }}">
                    </div>
                </div>
                
                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">NP</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" step="0.01" name="np" value="{{ old('np', $product->np) }}">
                    </div>
                </div>
                
                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">NR</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" step="0.01" name="nr" value="{{ old('nr', $product->nr) }}">
                    </div>
                </div>
                
                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.subcategory') }}</label>
                    <div class="col-md-10">
                        <select class="form-control" name="subcategory_id" required>
                            <option value="">{{ __('pages.select_category') }}</option>
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" {{ $subcategory->id == $product->subcategory_id ? 'selected' : '' }}>{{ $subcategory->name_en }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group mb-3 row">
                    @foreach ($countries as $country)
                        <label class='col-md-2 col-form-label' for="price_{{ $country->id }}">{{ $country->name }}</label>
                        <div class="col-md-10">
                            <input type="hidden" name="prices[{{ $country->id }}][country_id]" value="{{ $country->id }}">
                            <input type="number" step="0.01" name="prices[{{ $country->id }}][price]" id="price_{{ $country->id }}" class="form-control" value="{{ old('prices.'.$country->id.'.price', optional($product->prices->where('country_id', $country->id)->first())->price) }}">
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="image">{{ __('messages.product_image') }}</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="Product Image" class="img-fluid mt-2" style="max-width: 200px;">
                    @endif
                </div>
                
                
                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('pages.update_product') }}</button>
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
    
</script>

<script src="{{asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-editor.init.js')}}"></script>

@endsection
