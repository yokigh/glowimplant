@extends('admin.layouts.app')
@section('title', 'Create countries')
@section('header')
        
<style>
    .select2-container {
        width: 100% !important;
    }
</style>

@endsection
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

<form action="{{ route('countries.store', ['lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('pages.Create countries') }}</h4>
                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.name') }}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="name" value="">
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="col-md-2 col-form-label">{{ __('pages.select_currency') }}</label>
                        <div class="col-md-10">
                        <select id="currency" name="currency" class="form-control"></select>
                        </div>
                    </div>

                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('pages.create_subcategory') }}</button>
            </div>
        </div>
    </div>
</form>


@endsection

@section('script')

<link href="{{url('https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css')}}" rel="stylesheet" />
<script src="{{url('https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js')}}"></script>

<script>async function fetchCurrencies() {
    const apiKey = "8ce9c06326641d234d76eab5";  // استبدل بمفتاح API الخاص بك
    const url = `https://open.er-api.com/v6/latest/USD?apikey=${apiKey}`;

    try {
        const response = await fetch(url);
        const data = await response.json();

        if (data.rates) {
            const currencySelect = $("#currency");

            // تفريغ القائمة قبل إعادة تعبئتها
            currencySelect.empty();

            // إضافة خيار افتراضي
            currencySelect.append('<option value="">Select Currency</option>');

            // إضافة العملات
            $.each(data.rates, function (currency) {
                currencySelect.append(`<option value="${currency}">${currency}</option>`);
            });

            // تهيئة Select2 بعد تحميل العملات
            currencySelect.select2({
                placeholder: "Select Currency",
                allowClear: true,
                width: '100%'  // يجعل select2 يعمل بشكل صحيح
            });
        }
    } catch (error) {
        console.error("Error:", error);
    }
}

// تهيئة Select2 عند تحميل الصفحة
$(document).ready(function () {
    fetchCurrencies();
});

</script>

@endsection

