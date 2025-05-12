@extends('user.layout.app')
@section('hero')
   <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('user/assets/img/bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $product->subcategory ? $product->subcategory->{'name_' . app()->getLocale()} : '-' }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="home-medical-clinic.html">Home</a></li>
                    <li><a href="home-medical-clinic.html">Product</a></li>
                    <li>{{ $product->subcategory ? $product->subcategory->{'name_' . app()->getLocale()} : '-' }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
<!--==============================
    Product Details
    ==============================-->
    <section class="product-details space-top space-extra-bottom">
        <div class="container">
            <div class="row gx-60">
                <div class="col-lg-6">
                    <div class="product-big-img"   style="background-image: url('{{ asset('user/assets/img/bg_product.png') }}');background-size: cover;background-repeat: no-repeat;">
                        <div class="img"><img src="{{asset($product->image)}}" alt="Product Image"></div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="product-about">
                        
                    @php
                                    // التحقق مما إذا كان المستخدم مسجّل دخول
                                    $userCountryId = auth()->check() ? auth()->user()->country_id : null;

                                    // البحث عن الدولة في القائمة بناءً على country_id
                                    $selectedCountry = $countries->firstWhere('id', $userCountryId) ?? $countries->firstWhere('name', 'Germany');

                                    // جلب السعر بناءً على الدولة المحددة
                                    $price = $product->prices->where('country_id', $selectedCountry->id)->first();
                                @endphp
                                <h1>
                                {{ $price ? $price->price . ' ' . $selectedCountry->currency : 'N/A' }}

                                </h1>
                        <h2 class="product-title">{{ $product->ref }}</h2>
                        <div class="product-rating">
                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span></div>
                            <a href="shop-details.html" class="woocommerce-review-link">(<span class="count">4</span> customer reviews)</a>
                        </div>
                        <p class="text">
                            {!! $product->{'description_' . app()->getLocale()} !!}
                        </p>
                        <div class="actions">
                            <div class="quantity">
                            <input type="number" class="qty-input" step="1" min="1" max="100" name="quantity" value="1" title="Qty">
                            <button class="quantity-plus qty-btn"><i class="far fa-chevron-up"></i></button>
                                <button class="quantity-minus qty-btn"><i class="far fa-chevron-down"></i></button>
                            </div>
                            <a href="javascript:void(0);" class="th-btn add-to-cart" data-id="{{ $product->id }}">Add to Cart</a>
                        </div>
                        <div class="product_meta">
                            @if($product->diameter)
                            <span class="sku_wrapper">diameter: {{ $product->diameter }}</span>
                            @endif
                            @if($product->height)
                            <span class="posted_in">height	: {{ $product->height }}</span>
                            @endif
                            @if($product->np)
                            <span>np: {{ $product->np }}</span>
                            @endif
                            @if($product->nr)
                            <span>nr: {{ $product->nr }}</span>
                            @endif
                            
                            @php
                                    // التحقق مما إذا كان المستخدم مسجّل دخول
                                    $userCountryId = auth()->check() ? auth()->user()->country_id : null;

                                    // البحث عن الدولة في القائمة بناءً على country_id
                                    $selectedCountry = $countries->firstWhere('id', $userCountryId) ?? $countries->firstWhere('name', 'Germany');

                                    // جلب السعر بناءً على الدولة المحددة
                                    $price = $product->prices->where('country_id', $selectedCountry->id)->first();
                                @endphp
                                <span>
                                {{ $price ? $price->price . ' ' . $selectedCountry->currency : 'N/A' }}

                                </span>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav product-tab-style1" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link th-btn active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="false">Product Description</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link th-btn " href="{{ asset($product->subcategory->catalog) }}" download >Download Catalog</a>
                </li>
            </ul>
            <div class="tab-content" id="productTabContent">
                <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
                    
                {!! $product->{'description_' . app()->getLocale()} !!}
                </div>
                
            </div>

            <!--==============================
		Related Product  
		==============================-->
            <div class="row gy-40 filter-active">
                @foreach($prosthetic_products as $prosthetic_product)
                    <div class="col-xl-3 col-lg-4 col-sm-6 filter-item cat{{ $prosthetic_product->subcategory_id }}">
                    <div class="th-product product-grid">
                    <div class="product-img"  style="background-image: url('{{ asset('user/assets/img/bg_product.png') }}');background-size: cover;background-repeat: no-repeat;">
                                <img src="{{ asset( $prosthetic_product->image) }}" alt="{{ $prosthetic_product->{"name_$lang"} }}">
                            
                                <div class="actions">
                                    <a href="#QuickView" class="icon-btn popup-content"><i class="far fa-eye"></i></a>
                                    <a href="javascript:void(0);" class="icon-btn add-to-cart" data-id="{{ $prosthetic_product->id }}">
                                        <i class="far fa-cart-plus"></i>
                                    </a>
                                    <a href="" class="icon-btn"><i class="far fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="product-content">
                                {{-- <a href="" class="product-category">
                                    {{ $prosthetic_product->subcategory->{"name_$lang"} }}
                                </a> --}}
                                <h3 class="product-title">
                                    <a href="">{{ $prosthetic_product->ref }}</a>
                                </h3>


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
        var quantityInput = $(this).closest("div").find(".qty-input"); // البحث في نفس الحاوية
        var quantity = quantityInput.val();

        if (!quantity || quantity <= 0) {
            Swal.fire({
                icon: "error",
                title: "خطأ!",
                text: "يرجى إدخال كمية صحيحة."
            });
            return;
        }

        $.ajax({
            url: "{{ route('cart.add', ['lang' => app()->getLocale()]) }}",
            method: "POST",
            data: {
                product_id: productId,
                quantity: quantity, // تمرير الكمية الفعلية
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    title: "تم الإضافة!",
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });
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