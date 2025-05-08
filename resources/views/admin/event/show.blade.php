

@extends('admin.layouts.app')
@section('title','Show Category')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-5">
                                
                                    @if($event->image)
                                            <img src="{{ asset($event->image) }}" class="card-img" alt="...">

                                        @else
                                            No Image
                                        @endif
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">

                                        <h4 class="header-title">{{ $event->{'name_' . app()->getLocale()} }}</h4>

                                        <dl class="row mb-0">
                                            <dt class="col-sm-3">{{ __('pages.desc') }}</dt>
                                            <dd class="col-sm-9">{!! $event->{'description_' . app()->getLocale()} !!} <br></dd>

                                            <dt class="col-sm-3 text-truncate">{{ __('pages.date_event') }}</dt>
                                            <dd class="col-sm-9">{{ $event->event_date }}</dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.date_create') }}</dt>
                                            <dd class="col-sm-9">{{ $event->created_at }}</dd>
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.last_update') }}</dt>
                                            <dd class="col-sm-9">{{ $event->updated_at }}</dd>

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