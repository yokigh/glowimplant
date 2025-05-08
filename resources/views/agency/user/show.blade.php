@extends('agency.layouts.app')
@section('title','Show User')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-5">
                                
                                    @if($user->image)
                                            <img src="{{ asset('storage/' . $user->image) }}" class="card-img" alt="...">

                                        @else
                                            No Image
                                        @endif
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">

                                        <h4 class="header-title">{{ $user->name }}</h4>

                                        <dl class="row mb-0">
                                            <dt class="col-sm-3">{{ __('pages.email') }}</dt>
                                            <dd class="col-sm-9">{{ $user->email }} <br>
                                                @if(!empty($user->email_verified_at))
                                                <small style="color:green;">{{ __('pages.virifay') }} <br> {{ __('pages.date_virifay') }} : <b>{{ $user->email_verified_at }}</b> </small>
                                                @else
                                                <small style="color:red;">{{ __('pages.notvirifay') }}</small>
                                                <a href="{{ route('users.virifay', ['lang' => app()->getLocale(), 'user' => $user->id]) }}">{{ __('pages.send_virifay') }}</a>
                                                @endif
                                            </dd>

                                            <dt class="col-sm-3">{{ __('pages.birth') }}</dt>
                                            <dd class="col-sm-9">{{ $user->datebirthday }}</dd>

                                            <dt class="col-sm-3">{{ __('pages.job') }}</dt>
                                            <dd class="col-sm-9">{{ $user->job }}</dd>

                                            <dt class="col-sm-3 text-truncate">{{ __('pages.country') }}</dt>
                                            <dd class="col-sm-9">{{ $user->country->name }}</dd>
                                            
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.state') }}</dt>
                                            <dd class="col-sm-9">{{ $user->state }}</dd>
                                            
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.city') }}</dt>
                                            <dd class="col-sm-9">{{ $user->city }}</dd>
                                            
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.zipcode') }}</dt>
                                            <dd class="col-sm-9">{{ $user->zipcode }}</dd>
                                            
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.address1') }}</dt>
                                            <dd class="col-sm-9">{{ $user->address1 }}</dd>
                                            
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.address2') }}</dt>
                                            <dd class="col-sm-9">{{ $user->address2 }}</dd>
                                            
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.phone') }}</dt>
                                            <dd class="col-sm-9">{{ $user->phone }}</dd>
                                            
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.role') }}</dt>
                                            <dd class="col-sm-9">{{ $user->role }}</dd>
                                            
                                            <dt class="col-sm-3 text-truncate">{{ __('pages.date_create') }}</dt>
                                            <dd class="col-sm-9">{{ $user->created_at }}</dd>


                                        </dl>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
             
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">{{ __('pages.date_session') }}</h4>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('pages.ip_address') }}</th>
                                            <th>{{ __('pages.user_agent') }}</th>
                                            <th>{{ __('pages.login_at') }}</th>
                                            <th>{{ __('pages.logout_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activities as $activitie)
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>{{ $activitie->ip_address }}</td>
                                            <td>{{ $activitie->user_agent }}</td>
                                            <td>{{ $activitie->created_at }}</td>
                                            <td>{{ $activitie->logout_at }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection