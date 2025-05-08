@extends('admin.layouts.app')
@section('title', 'Prostatic Category')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('pages.show_prostatic_category') }}</h4>

                @php
                    $languages = ['en', 'de', 'fr', 'es', 'ar'];
                @endphp

                @foreach ($languages as $lang)
                    <div class="mb-3">
                        <strong>{{ __('pages.name') }} ({{ strtoupper($lang) }}):</strong>
                        <p>{{ $prostatic_category->{'name_' . $lang} }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>{{ __('pages.desc') }} ({{ strtoupper($lang) }}):</strong>
                        <p>{!! $prostatic_category->{'description_' . $lang} !!}</p>
                    </div>
                @endforeach

                <div class="mb-3">
                    <strong>{{ __('pages.subcategories') }}:</strong>
                    <ul>
                        @foreach ($prostatic_category->subcategories as $subcategory)
                            <li>{{ $subcategory->{'name_' . app()->getLocale()} }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="mb-3">
                    <strong>{{ __('pages.image') }}:</strong><br>
                    @if ($prostatic_category->image)
                        <img src="{{ asset($prostatic_category->image) }}" alt="Category Image" style="max-width: 300px;">
                    @else
                        <p>{{ __('messages.no_image_available') }}</p>
                    @endif
                </div>
                <a href="{{ route('prostatic_categories.edit', ['lang' => app()->getLocale(), 'prostatic_category' => $prostatic_category->id]) }}" 
                    class="btn btn-warning">
                    {{ __('pages.edit') }}
                 </a>

                <a href="{{ route('prostatic_categories.index', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">
                    {{ __('pages.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection