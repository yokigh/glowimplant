@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Product Details</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h3>{{ $prostheticProduct->{'name_' . app()->getLocale()} }}</h3>
            <p>{!! $prostheticProduct->{'description_' . app()->getLocale()} !!}</p>

            <p><strong>Ref:</strong> {{ $prostheticProduct->ref }}</p>
            <p><strong>Diameter:</strong> {{ $prostheticProduct->diameter }}</p>
            <p><strong>Height:</strong> {{ $prostheticProduct->height }}</p>
            <p><strong>ML:</strong> {{ $prostheticProduct->ml }}</p>
            <p><strong>Angle:</strong> {{ $prostheticProduct->angle }}</p>
            <p><strong>Screw Ref:</strong> {{ $prostheticProduct->screw_ref }}</p>
            <p><strong>Category:</strong> {{ $prostheticProduct->prostheticCategory->{'name_' . app()->getLocale()} ?? '—' }}</p>

            <div>
                <strong>Main Image:</strong><br>
                @if ($prostheticProduct->image)
                    <img src="{{ asset($prostheticProduct->image) }}" style="max-width: 200px;" alt="">
                @else
                    <span>No Image</span>
                @endif
            </div>

            <div class="mt-3">
                <strong>Gallery Images:</strong><br>
                @if ($prostheticProduct->images)
                    @foreach (json_decode($prostheticProduct->images, true) as $img)
                        <img src="{{ asset($img) }}" style="width: 100px; height: 100px; object-fit: cover;" class="m-1" alt="">
                    @endforeach
                @else
                    <span>No Gallery Images</span>
                @endif
            </div>
        </div>
    </div>

    <a href="{{ route('prosthetic_products.index', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">Back</a>
    <a href="{{ route('prosthetic_products.edit', ['lang' => app()->getLocale(), 'prosthetic_product' => $prostheticProduct->id]) }}" class="btn btn-warning">Edit</a>
</div>
@endsection
