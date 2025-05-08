@extends('admin.layouts.app')
@section('title', 'Edit Country')
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

<form action="{{ route('countries.update', ['country' => $country->id, 'lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    @method('PUT')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('pages.Edit Country') }}</h4>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.name') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="name" value="{{ old('name', $country->name) }}">
                    </div>
                </div>

                <div class="form-group mb-3 row">
                    <label class="col-md-2 col-form-label">{{ __('pages.select_currency') }}</label>
                    <div class="col-md-10">
                        <select id="currency" name="currency" class="form-control">
                            <option value="{{ $country->currency }}" selected>{{ $country->currency }}</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('pages.update') }}</button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')
<script>
    async function fetchCurrencies() {
        const apiKey = "8ce9c06326641d234d76eab5";  // استبدل بمفتاح API الخاص بك
        const url = `https://open.er-api.com/v6/latest/USD?apikey=${apiKey}`;

        try {
            const response = await fetch(url);
            const data = await response.json();
            
            if (data.rates) {
                const currencySelect = document.getElementById("currency");
                Object.keys(data.rates).forEach(currency => {
                    let option = document.createElement("option");
                    option.value = currency;
                    option.textContent = currency;
                    currencySelect.appendChild(option);
                });

                // تعيين العملة المحفوظة سابقًا كخيار محدد
                currencySelect.value = "{{ $country->currency }}";
            }
        } catch (error) {
            console.error("error:", error);
        }
    }

    fetchCurrencies();
</script>
@endsection
