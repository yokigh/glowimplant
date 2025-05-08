@extends('admin.layouts.app')
@section('title', __('pages.Show Contact'))
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-5 text-center">
                                @if($contactu->map)
                                    <iframe 
                                        src="https://www.google.com/maps?q={{ $contactu->map }}&output=embed" 
                                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                                    </iframe>
                                @else
                                    <p>No Map Available</p>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h4 class="header-title">{{ $contactu->{'name_' . app()->getLocale()} }}</h4>
                                    
                                    <dl class="row mb-0">
                                        <dt class="col-sm-3">{{ __('pages.email') }}</dt>
                                        <dd class="col-sm-9">{{ $contactu->email }}</dd>
                                        <dt class="col-sm-3">{{ __('pages.desc') }}</dt>
                                        <dd class="col-sm-9">{!! $contactu->{'description_' . app()->getLocale()} !!}</dd>

                                        <dt class="col-sm-3">{{ __('pages.phone') }}</dt>
                                        <dd class="col-sm-9">{{ $contactu->phone }}</dd>

                                        <dt class="col-sm-3">{{ __('pages.country') }}</dt>
                                        <dd class="col-sm-9">{{ $contactu->country->name }}</dd>

                                        <dt class="col-sm-3">{{ __('pages.address') }}</dt>
                                        <dd class="col-sm-9">{{ $contactu->address }}</dd>

                                        <dt class="col-sm-3">{{ __('pages.date_create') }}</dt>
                                        <dd class="col-sm-9">{{ $contactu->created_at }}</dd>

                                        <dt class="col-sm-3">{{ __('pages.last_update') }}</dt>
                                        <dd class="col-sm-9">{{ $contactu->updated_at }}</dd>
                                    </dl>‍
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">{{ __('pages.social_links') }}</h4>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('pages.platform') }}</th>
                                            <th>{{ __('pages.link') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $socialLinks = ['facebook', 'whatsapp', 'instagram', 'tiktok', 'x', 'youtube'];
                                        @endphp
                                        @foreach ($socialLinks as $social)
                                            <tr>
                                                <td>{{ ucfirst($social) }}</td>
                                                <td>
                                                    @if($contactu->{'url_' . $social})
                                                        <a href="{{ $contactu->{'url_' . $social} }}" target="_blank">
                                                            {{ __('pages.view_link') }}
                                                        </a>
                                                    @else
                                                        {{ __('pages.no_link') }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>  
            <!-- Social Links Section -->
             @endsection