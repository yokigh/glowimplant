@extends('user.layout.app')

@section('content')
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

<div class="container text-center mt-5">
    <h2>Payment Successful</h2>
    <p>Thank you for your payment! Your order has been placed successfully.</p>
    <a href="{{ route('home.page', ['lang' => app()->getLocale()]) }}" class="btn btn-primary">Return to Home</a>
</div>
@endsection
