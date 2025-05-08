@extends('user.layout.app')
@section('hero')
    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('user/assets/img/bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{$subcategory->{'name_' . app()->getLocale()} }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="home-medical-clinic.html">Home</a></li>
                    <li><a href="home-medical-clinic.html">{{ $subcategory->category ? $subcategory->category->{'name_' . app()->getLocale()} : '-' }}</a></li>
                    <li>{{$subcategory->{'name_' . app()->getLocale()} }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')

<section class="space-top space-extra-bottom">
        <div class="container">
            <div class="th-sort-bar">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md">
                        <p class="woocommerce-result-count">
                        <div class="widget widget_search">
                            <form class="search-form">
                                <input type="text" id="searchInput" placeholder="Enter ref">
                                <div id="searchResults" class="dropdown-menu" style="display: none; position: absolute; width: 100%; max-height: 200px; overflow-y: auto;"></div>
                            </form>
                        </div>

                    </p>
                    </div>

                </div>
            </div>
            <div class="row gy-40">
            @foreach($subcategory->products as $product)
                    <div class="col-xl-3 col-lg-4 col-sm-6 filter-item cat{{ $product->subcategory_id }}">
                    <div class="th-product product-grid">
                    <div class="product-img"  style="background-image: url('{{ asset('user/assets/img/bg_product.png') }}');background-size: cover;background-repeat: no-repeat;">
                                <img src="{{ asset( $product->image) }}" alt="{{ $product->{'name_' . app()->getLocale()} }}">
                            
                                <div class="actions">
                                    <a href="#QuickView" class="icon-btn popup-content"><i class="far fa-eye"></i></a>
                                    <a href="javascript:void(0);" class="icon-btn add-to-cart" data-id="{{ $product->id }}">
                                        <i class="far fa-cart-plus"></i>
                                    </a>
                                    <a href="" class="icon-btn"><i class="far fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="product-content">
                                <a href="" class="product-category">
                                    {{ $product->subcategory->{'name_' . app()->getLocale()} }}
                                </a>
                                <h3 class="product-title">
                                    <a href="">{{ $product->ref }}</a>
                                </h3>
                                @php
                                    // التحقق مما إذا كان المستخدم مسجّل دخول
                                    $userCountryId = auth()->check() ? auth()->user()->country_id : null;

                                    // البحث عن الدولة في القائمة بناءً على country_id
                                    $selectedCountry = $countries->firstWhere('id', $userCountryId) ?? $countries->firstWhere('name', 'Germany');

                                    // جلب السعر بناءً على الدولة المحددة
                                    $price = $product->prices->where('country_id', $selectedCountry->id)->first();
                                @endphp

                                <span class="price">
                                    <b>{{ $selectedCountry->name }} :</b> 
                                    {{ $price ? $price->price . ' ' . $selectedCountry->currency : 'N/A' }}
                                </span>


                            </div>
                        </div>
                    </div>
                    
                @endforeach


            </div>
        </div>
    </section>
@endsection
@section('script')
<script src="{{url('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function () {
    let lang = "{{ app()->getLocale() }}"; // جلب اللغة الحالية

    $('#searchInput').on('keyup', function () {
        let query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: `/${lang}/search-products`, // تمرير اللغة في الـ URL
                type: "GET",
                data: { query: query },
                success: function (data) {
                    let dropdown = $("#searchResults");
                    dropdown.empty().show();
                    
                    if (data.length > 0) {
                        $.each(data, function (index, product) {
                            dropdown.append(`<a class="dropdown-item" href="/${lang}/products/${product.id}">
                                                ${product.ref}
                                             </a>`);
                        });
                    } else {
                        dropdown.append('<a class="dropdown-item text-muted">No results found</a>');
                    }
                }
            });
        } else {
            $("#searchResults").hide();
        }
    });

    // إخفاء الـ Dropdown عند النقر خارجًا
    $(document).click(function (event) {
        if (!$(event.target).closest('.search-form').length) {
            $("#searchResults").hide();
        }
    });
});

</script>

<script src="{{url('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>

<script>
$(document).ready(function() {
    $(".add-to-cart").click(function() {
        var productId = $(this).data("id");

        $.ajax({
            url: "{{ route('cart.add', ['lang' => app()->getLocale()]) }}",
            method: "POST",
            data: {
                product_id: productId,
                quantity: 1, // كمية افتراضية
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "تم الإضافة!",
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "خطأ!",
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "خطأ!",
                    text: "حدث خطأ أثناء الإضافة إلى السلة."
                });
            }
        });
    });
});

</script>

@endsection