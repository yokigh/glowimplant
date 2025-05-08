<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Cart;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        $cartItems = Cart::where('user_id', auth()->id())
        ->where('status_pay', false)
        ->get();
$userCountryId = auth()->user()->country_id ?? null;
        $selectedCountry = \App\Models\Country::find($userCountryId) ?? \App\Models\Country::where('name', 'Germany')->first();
        $cartTotal = $cartItems->sum(fn($item) => ($item->product->prices->where('country_id', $selectedCountry->id)->first()?->price ?? 0) * $item->quantity);

        return view('user.checkout.index', compact('cartItems', 'selectedCountry', 'cartTotal'));
    }

}
