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
            <div class="space-extra-top mb-30">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-auto">
                        <h2 class="sec-title text-center">Related Products</h2>
                    </div>
                    <div class="col-md d-none d-sm-block">
                        <hr class="title-line">
                    </div>
                    <div class="col-md-auto d-none d-md-block">
                        <div class="sec-btn">
                            <div class="icon-box">
                                <button data-slider-prev="#productSlider1" class="slider-arrow default"><i class="far fa-arrow-left"></i></button>
                                <button data-slider-next="#productSlider1" class="slider-arrow default"><i class="far fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper th-slider has-shadow" id="productSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">
                        @foreach ($products as $oneproduct)
                            
                        <div class="swiper-slide">
                            <div class="th-product product-grid">
                                <div class="product-img">
                                    <img src="{{asset($oneproduct->image)}}" alt="Product Image">
                                    <div class="actions">
                                        <a href="#QuickView" class="icon-btn popup-content"><i class="far fa-eye"></i></a>
                                        <a href="cart.html" class="icon-btn"><i class="far fa-cart-plus"></i></a>
                                        <a href="wishlist.html" class="icon-btn"><i class="far fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <a href="shop-details.html" class="product-category">{{ $oneproduct->subcategory ? $oneproduct->subcategory->{'name_' . app()->getLocale()} : '-' }}</a>
                                    <h3 class="product-title"><a href="shop-details.html">{{ $oneproduct->ref }}</a></h3>
                                    <span class="price">
                                        
                                    @foreach ($countries as $country)
                                                        @php
                                                            $price = $oneproduct->prices->where('country_id', $country->id)->first();
                                                        @endphp
                                                            <li style="color: {{ $price ? 'green' : 'red' }};">
                                                                {{$country->name}} : 
                                                            {{ $price ? $price->price . ' ' . $price->currency : 'N/A' }}
                                                            @if(isset($currencyDifferences[$country->currency]) && $currencyDifferences[$country->currency] !== null)
                                                            <br>
                                                               <span style="color:#0befc2;">{{ __('pages.every 1 eur aqual =') }} {{ number_format($currencyDifferences[$country->currency], 4) }}</span>
                                                            @else
                                                                N/A
                                                            @endif

                                                            </li>
                                                      @endforeach
                                    </span>
                                </div>
                            </div>
                        </div>

                        @endforeach


                    </div>
                </div>
                <div class="d-block d-md-none mt-40 text-center">
                    <div class="icon-box">
                        <button data-slider-prev="#productSlider1" class="slider-arrow default"><i class="far fa-arrow-left"></i></button>
                        <button data-slider-next="#productSlider1" class="slider-arrow default"><i class="far fa-arrow-right"></i></button>
                    </div>
                </div>
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