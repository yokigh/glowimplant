@extends('user.layout.app')
@section('hero')
    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('user/assets/img/bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">All Product</h1>
                <ul class="breadcumb-menu">
                    <li><a href="home-medical-clinic.html">Home</a></li>
                    <li>All Product</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <!--==============================
Product Area
==============================-->
<section class="space" id="shop-sec">
        <div class="container">
            <div class="row justify-content-lg-between justify-content-center align-items-center">
                <div class="col-lg-auto">
                    <h3 class="sec-title text-center">Our Latest Products</h3>
                </div>
                <div class="col-lg-auto">
                    <div class="filter-menu filter-menu-active">
                        <button data-filter="*" class="th-btn active" type="button">All Products</button>
                        @foreach($subcategories as $subcategory)
                            <button data-filter=".cat{{ $subcategory->id }}" class="th-btn" type="button">
                                {{ $subcategory->name_en }} 
                            </button>
                        @endforeach
                    </div>

                </div>
            </div>
            <div class="row gy-40 filter-active">
                @foreach($products as $product)
                    <div class="col-xl-3 col-lg-4 col-sm-6 filter-item cat{{ $product->subcategory_id }}">
                    <div class="th-product product-grid">
                    <div class="product-img"  style="background-image: url('{{ asset('user/assets/img/bg_product.png') }}');background-size: cover;background-repeat: no-repeat;">
                                <img src="{{ asset( $product->image) }}" alt="{{ $product->{"name_$lang"} }}">
                            
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
                                    {{ $product->subcategory->{"name_$lang"} }}
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