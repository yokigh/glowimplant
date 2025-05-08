@extends('admin.layouts.app')

@section('title', 'Show Product')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-5">
                                
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" class="card-img" alt="...">
                                @else
                                    No Image
                                @endif
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">

                                    <h4 class="header-title">{{ $product->ref }}</h4>

                                    <dl class="row mb-0">
                                        <dt class="col-sm-3 text-truncate">{{ __('pages.diameter') }}</dt>
                                        <dd class="col-sm-9">{{ $product->diameter }}</dd>
                                        <dt class="col-sm-3 text-truncate">{{ __('pages.height') }}</dt>
                                        <dd class="col-sm-9">{{ $product->height }}</dd>
                                        <dt class="col-sm-3">{{ __('pages.desc') }}</dt>
                                        <dd class="col-sm-9">{!! $product->{'description_' . app()->getLocale()} !!} <br></dd>

                                        <dt class="col-sm-3 text-truncate">{{ __('pages.date_create') }}</dt>
                                        <dd class="col-sm-9">{{ $product->created_at }}</dd>
                                        <dt class="col-sm-3 text-truncate">{{ __('pages.last_update') }}</dt>
                                        <dd class="col-sm-9">{{ $product->updated_at }}</dd>

                                        <dt class="col-sm-3 text-truncate">{{ __('pages.subcategory') }}</dt>
                                        <dd class="col-sm-9">{{ $product->subcategory ? $product->subcategory->{'name_' . app()->getLocale()} : '-' }}</dd>

                                        <dt class="col-sm-3 text-truncate">{{ __('pages.category') }}</dt>
                                        <dd class="col-sm-9">{{ $product->subcategory && $product->subcategory->category ? $product->subcategory->category->{'name_' . app()->getLocale()} : '-' }}</dd>

                                        <!-- عرض الأسعار للدول -->
                                        <dt class="col-sm-3 text-truncate">{{ __('pages.price') }}</dt>
                                        <dd class="col-sm-9">
                                            
                                        <ul>
                                                        @foreach ($countries as $country)
                                                        @php
                                                            $price = $product->prices->where('country_id', $country->id)->first();
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
                                                      </ul>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>
</div>

@endsection
