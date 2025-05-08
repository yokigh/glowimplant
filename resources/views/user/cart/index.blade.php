@extends('user.layout.app')
@section('hero')
    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('user/assets/img/bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Cart</h1>
                <ul class="breadcumb-menu">
                    <li><a href="home-medical-clinic.html">Home</a></li>
                    <li>Cart</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
<div class="th-cart-wrapper  space-top space-extra-bottom">
        <div class="container">
            <div class="woocommerce-notices-wrapper">
                <div class="woocommerce-message">Shipping costs updated.</div>
            </div>
            <form action="#" class="woocommerce-cart-form">
                <table class="cart_table">
                    <thead>
                        <tr>
                            <th class="cart-col-image">Image</th>
                            <th class="cart-col-productname">Product Name</th>
                            <th class="cart-col-price">Price</th>
                            <th class="cart-col-quantity">Quantity</th>
                            <th class="cart-col-total">Total</th>
                            <th class="cart-col-remove">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if ($cartItems->isNotEmpty()) 
                    @foreach($cartItems as $item)
                    <tr class="cart_item">
                        <td data-title="Product">
                            <a class="cart-productimage" href="shop-details.html">
                                <img width="91" height="91" src="{{ asset($item->product->image) }}" alt="Image">
                            </a>
                        </td>
                        <td data-title="Name">
                            <a class="cart-productname" href="shop-details.html">{{ $item->product->{'name_' . app()->getLocale()} }}</a>
                        </td>

                        @php
                            $userCountryId = auth()->check() ? auth()->user()->country_id : null;
                            $selectedCountry = $countries->firstWhere('id', $userCountryId) ?? $countries->firstWhere('name', 'Germany');
                            $price = $item->product->prices->where('country_id', $selectedCountry->id)->first();
                        @endphp

                        <td data-title="Price">
                            <span class="amount">
                                <bdi><span>{{ $selectedCountry->currency }}</span> {{ $price ? $price->price : 'N/A' }}</bdi>
                            </span>
                        </td>

                        <td data-title="Quantity">
                            <div class="quantity">
                                <button class="quanti-minus qty-btn" data-id="{{ $item->id }}"><i class="far fa-minus"></i></button>
                                <input type="number" class="qty-input" value="{{ $item->quantity }}" min="1" max="99" data-id="{{ $item->id }}">
                                <button class="quanti-plus qty-btn" data-id="{{ $item->id }}"><i class="far fa-plus"></i></button>
                            </div>
                        </td>

                        <td data-title="Total">
                            <span class="amount">
                                <bdi><span>{{ $selectedCountry->currency }}</span> <span class="total-price" data-id="{{ $item->id }}">{{ $price ? $price->price * $item->quantity : 'N/A' }}</span></bdi>
                            </span>
                        </td>

                        <td data-title="Remove">
                            <a href="{{ route('cart.remove', ['lang' => app()->getLocale(), 'id' => $item->id]) }}" class="remove">
                                <i class="fal fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="cart_item">
                        <td data-title="Product">N/A</td>
                        <td data-title="Product">N/A</td>
                        <td data-title="Product">N/A</td>
                        <td data-title="Product">N/A</td>
                        <td data-title="Product">N/A</td>
                        <td data-title="Product">N/A</td>
                    </tr>
                    @endif


                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Total:</th>
                            <th colspan="2">
                                <span class="cart-total">
                                    @if ($cartItems->isNotEmpty()) 
                                    <bdi><span>{{ $selectedCountry->currency }}</span> <span id="cart-total">{{ $cartItems->sum(fn($item) => ($item->product->prices->where('country_id', $selectedCountry->id)->first()?->price ?? 0) * $item->quantity) }}</span></bdi>

                                    @else
                                    <bdi><span id="cart-total">N/A</span></bdi>
                                    @endif
                                </span>
                            </th>
                        </tr>
                    </tfoot>

                </table>
            </form>
            <div class="checkout-button-container text-right">
                <a href="{{ route('checkout', ['lang' => app()->getLocale()]) }}" class="btn btn-primary">Proceed to Checkout</a>
            </div>

        </div>
    </div>
@endsection
@section('script')
<script>
    function updateCartTotal() {
        let total = 0;
        $(".total-price").each(function() {
            total += parseFloat($(this).text());
        });
        $("#cart-total").text(total.toFixed(2));
    }

    $(".qty-input").on("change", function(event) {
        event.preventDefault(); // منع التصرف الافتراضي

        let scrollPosition = $(window).scrollTop(); // حفظ موضع التمرير

        let itemId = $(this).data("id");
        let newQuantity = $(this).val();

        if (newQuantity < 1) {
            newQuantity = 1;
            $(this).val(1);
        }

        $.ajax({
            url: "{{ route('cart.update', ['lang' => app()->getLocale()]) }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: itemId,
                quantity: newQuantity
            },
            success: function(response) {
                if (response.success) {
                    $(".total-price[data-id='" + itemId + "']").text(response.newTotal);
                    updateCartTotal();
                }
                window.scrollTo(0, scrollPosition); // إعادة التمرير إلى نفس المكان
            }
        });
    });

    $(".quanti-minus, .quanti-plus").on("click", function(event) {
        event.preventDefault(); // منع التصرف الافتراضي

        let input = $(this).siblings(".qty-input");
        let itemId = input.data("id");
        let currentQuantity = parseInt(input.val());

        if ($(this).hasClass("quanti-minus") && currentQuantity > 1) {
            input.val(currentQuantity - 1).trigger("change");
        } else if ($(this).hasClass("quanti-plus")) {
            input.val(currentQuantity + 1).trigger("change");
        }
    });
</script>

@endsection
