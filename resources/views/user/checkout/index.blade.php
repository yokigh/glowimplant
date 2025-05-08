@extends('user.layout.app')

@section('content')
<div class="checkout-container space-top space-extra-bottom">
    <div class="container">
        <h2 class="text-center">Checkout</h2>
        <div class="row">
            <!-- عرض المنتجات في السلة -->
            <div class="col-md-6">
                <h4>Your Cart</h4>
                <ul class="list-group">
                    @foreach($cartItems as $item)
                        <li class="list-group-item">
                            <strong>{{ $item->product->subcategory->{'name_' . app()->getLocale()} }} ( {{ $item->product->ref }} )</strong> 
                            x {{ $item->quantity }} = 
                            <span>{{ $selectedCountry->currency }} {{ $price = $item->product->prices->where('country_id', $selectedCountry->id)->first()?->price * $item->quantity }}</span>
                        </li>
                    @endforeach
                </ul>
                <h4 class="mt-3">Total: <span>{{ $selectedCountry->currency }} {{ $cartTotal }}</span></h4>
            </div>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="col-md-6">
                <form action="{{ route('checkout.charge', ['lang' => app()->getLocale()]) }}" method="POST" id="payment-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" name="country" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" name="state" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="building_number">Building Number (Optional)</label>
                        <input type="text" name="building_number" class="form-control">
                    </div>
                    
                    <input type="hidden" name="total_price" value="{{ $cartTotal }}">
                    <input type="hidden" name="currency" value="{{ $selectedCountry->currency }}">
                    
                    <div class="form-group">
                        <label for="card-element">Credit or Debit Card</label>
                        <div id="card-element" class="form-control"></div>
                        <div id="card-errors" role="alert"></div>
                    </div>

                    <button type="submit" class="btn btn-success btn-block mt-3">Pay with Stripe</button>
                </form>

                <script src="https://js.stripe.com/v3/"></script>
                <script>
                    var stripe = Stripe("{{ config('services.stripe.key') }}");
                    var elements = stripe.elements();
                    var card = elements.create('card');
                    card.mount('#card-element');

                    var form = document.getElementById('payment-form');
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();

                        stripe.createToken(card).then(function(result) {
                            if (result.error) {
                                document.getElementById('card-errors').textContent = result.error.message;
                            } else {
                                var hiddenInput = document.createElement('input');
                                hiddenInput.setAttribute('type', 'hidden');
                                hiddenInput.setAttribute('name', 'stripeToken');
                                hiddenInput.setAttribute('value', result.token.id);
                                form.appendChild(hiddenInput);
                                form.submit();
                            }
                        });
                    });
                </script>

            </div>
        </div>
    </div>
</div>
@endsection
