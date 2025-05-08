@extends('user.layout.app')
@section('hero')

    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('user/assets/img/bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Contact</h1>
                <ul class="breadcumb-menu">
                    <li><a href="home-medical-clinic.html">Home</a></li>
                    <li>Contact</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
<div class="space">
        <div class="container">
            <div class="row">
                @foreach ($contacts as $contact)
    
                <div class="col">
                <a class="nav-link th-btn " href="{{route('contactshow.page', ['lang' => app()->getLocale() , 'contac' => $contact->id])}}" >{{ $contact->country->name }}</a>

                </div>
                @endforeach

            </div>
            <div class="row gy-4" style="margin-top:20px;">
                <div class="col-xl-4 col-md-6">
                    <div class="location-card">
                        <h3 class="box-title">{{ __('messages.link' )}}</h3>
                        <ul style="list-style-type: none;">
                            <li><a href="{{$contac->url_facebook}}"><i class="fab fa-facebook-f"></i></a>  {{ __('messages.facebook') }}</li>
                            <li><a href="{{$contac->url_x}}"><i class="fa-brands fa-x-twitter"></i></a>  {{ __('messages.x-twitter') }}</li>
                            <li><a href="{{$contac->url_whatsapp}}"><i class="fab fa-whatsapp"></i></a>  {{ __('messages.whatsapp') }}</li>
                            <li><a href="{{$contac->url_instagram}}"><i class="fa-brands fa-instagram"></i></a>  {{ __('messages.instagram') }}</li>
                            <li><a href="{{$contac->url_tiktok}}"><i class="fa-brands fa-tiktok"></i></a>  {{ __('messages.tiktok') }}</li>
                            <li><a href="{{$contac->url_youtube}}"><i class="fab fa-youtube"></i></a>  {{ __('messages.youtube') }}</li>
                        </ul>
                        
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="location-card active">
                        <h3 class="box-title">{{ __('messages.contact' )}}</h3>
                        <p class="footer-info">
                            <i class="far fa-envelope"></i>
                            <a href="mailto:{{$contac->email}}" class="info-box_link">{{$contac->email}}</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-phone"></i>
                            <a href="tel:{{$contac->phone}}" class="info-box_link">{{$contac->phone}}</a>
                        </p>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="location-card">
                        <h3 class="box-title">{{ __('messages.addrees' )}}</h3>
                        <p class="footer-info">
                        {{$contac->country->name}}
                        </p>
                        <p class="footer-info">
                            <i class="far fa-location-dot"></i>
                            {{$contac->address}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> 
     <!--==============================
Contact Area   
==============================-->
<div class="space-bottom">
        <div class="container">
            <form action="mail.php" method="POST" class="contact-form ajax-contact" style="display: flex;justify-content: space-around;flex-wrap: wrap;" data-bg-src="{{ asset('user/assets/img/bg.jpg') }}">
                <div class="input-wrap">
                    <h2 class="sec-title">{{ $contac->{'name_' . app()->getLocale()} }}</h2>
                    <div class="row">
                        <div class="form-group col-12">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Your Name">
                            <i class="fal fa-user"></i>
                        </div>
                        <div class="form-group col-12">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
                            <i class="fal fa-envelope"></i>
                        </div>
                        <div class="form-group col-12">
                            <input type="tel" class="form-control" name="number" id="number" placeholder="Phone Number">
                            <i class="fal fa-phone"></i>
                        </div>
                        <div class="form-group col-12">
                            <select name="subject" id="subject" class="form-select">
                                <option value="" disabled selected hidden>Select Subject</option>
                                <option value="Make Appointment">Make Appointment</option>
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="Medicine Help">Medicine Help</option>
                                <option value="Consultation">Consultation</option>
                            </select>
                            <i class="fal fa-chevron-down"></i>
                        </div>
                        <div class="form-group col-12">
                            <textarea name="message" id="message" cols="30" rows="3" class="form-control" placeholder="Type Appointment Note..."></textarea>
                            <i class="fal fa-pencil"></i>
                        </div>
                        <div class="form-btn col-12">
                            <button class="th-btn btn-fw">BOOK AN APPOINTMENT</button>
                        </div>
                    </div>
                    <p class="form-messages mb-0 mt-3"></p>
                </div>
                <div class="input-wrap">
                {!! $contac->{'description_' . app()->getLocale()} !!}
</div>
            </form>
            <div>
            
            </div>
        </div>
    </div><!--==============================
Map Area  
==============================-->
    <div class="">
        <div class="contact-map">
            <iframe src="{{$contac->map}}" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

@endsection