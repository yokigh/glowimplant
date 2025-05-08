<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>GlowImplant implant & prosthtic Shop</title>
    <meta name="author" content="GlowImplant">
    <meta name="description" content="GlowImplant implant & prosthtic Shop">
    <meta name="keywords" content="GlowImplant implant & prosthtic Shop">
    <meta name="robots" content="GlowImplant,implant,prosthtic">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('assets/images/logo/glow.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/images/logo/glow.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/images/logo/glow.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/images/logo/glow.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/images/logo/glow.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/images/logo/glow.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/images/logo/logo.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/images/logo/logo.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/images/logo/logo.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('assets/images/logo/logo.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/logo/glow.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/images/logo/glow.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/logo/glow.png')}}">
    <link rel="manifest" href="{{asset('assets/images/logo/glow.png')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('assets/images/logo/glow.png')}}">
    <meta name="theme-color" content="#ffffff">

    <!--==============================
	  Google Fonts
	============================== -->
    <link rel="preconnect" href="{{url('https://fonts.googleapis.com')}}">
    <link rel="preconnect" href="{{url('https://fonts.gstatic.com')}}" crossorigin>
    <link href="{{url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100;9..40,200;9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap')}}" rel="stylesheet">

    <!--==============================
	    All CSS File
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('user/assets/css/bootstrap.min.css')}}">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="{{asset('user/assets/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css')}}" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <!-- Magnific Popup -->

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{asset('user/assets/css/magnific-popup.min.css')}}">
    <!-- Swiper Js -->
    <link rel="stylesheet" href="{{asset('user/assets/css/swiper-bundle.min.css')}}">
    <!-- datetimepicker -->
    <link rel="stylesheet" href="{{asset('user/assets/css/jquery.datetimepicker.min.css')}}">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset('user/assets/css/style.css')}}">

</head>

<body>

    <!--[if lte IE 9]>
    	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  	<![endif]-->


    <!--********************************
   		Code Start From Here 
	******************************** -->

    <!--==============================
     Preloader
  ==============================-->
    <div class="preloader ">
        <div class="preloader-inner">
            <div class="loader"></div>
        </div>
    </div>
    <!--==============================
    Sidemenu
============================== -->
<!--==============================
    Sidemenu
============================== -->
@include('user.layout.mobile')
    <!--==============================
	Header Area
==============================-->
@include('user.layout.desctop')
    @yield('hero')
    @yield('content')
    <!--==============================
	Footer Area
==============================-->
    <footer class="footer-wrapper footer-layout2" data-bg-src="assets/img/bg/footer_bg_2.jpg">
        <div class="widget-area">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">{{ __('messages.Contact') }}</h3>
                            <div class="th-widget-contact">
                                <p class="footer-text">{{ __('messages.Keep up to date with our latest news & special offer') }}.</p>
                                <p class="footer-info">
                                    <i class="fal fa-location-dot"></i>
                                    {{$firstcontactUs->address}}
                                </p>
                                <p class="footer-info">
                                    <i class="fal fa-envelope"></i>
                                    <a href="mailto:{{$firstcontactUs->email}}" class="info-box_link">{{$firstcontactUs->email}}</a>
                                </p>
                                <p class="footer-info">
                                    <i class="fal fa-phone"></i>
                                    <a href="tel:{{$firstcontactUs->phone}}" class="info-box_link">{{$firstcontactUs->phone}}</a>
                                </p>
                                <div class="th-social">
                                    <a href="{{$firstcontactUs->url_facebook}}"><i class="fab fa-facebook-f"></i></a>
                                    <a href="{{$firstcontactUs->url_x}}"><i class="fa-brands fa-x-twitter"></i></a>
                                    <a href="{{$firstcontactUs->url_whatsapp}}"><i class="fab fa-whatsapp"></i></a>
                                    <a href="{{$firstcontactUs->url_instagram}}"><i class="fa-brands fa-instagram"></i></a>
                                    <a href="{{$firstcontactUs->url_tiktok}}"><i class="fa-brands fa-tiktok"></i></a>
                                    <a href="{{$firstcontactUs->url_youtube}}"><i class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">{{ __('messages.Quick Links') }}</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <li><a href="">{{ __('messages.About Us') }}</a></li>
                                    <li><a href="">{{ __('messages.Terms of Use') }}</a></li>
                                    <li><a href="">{{ __('messages.Products') }}</a></li>
                                    <li><a href="">{{ __('messages.Help & FAQs') }}</a></li>
                                    <li><a href="">{{ __('messages.Contact us') }}</a></li>
                                    <li><a href="">{{ __('messages.Privacy policy') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">{{ __('messages.Popular Category') }}</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                @foreach ($layoutcategories as $category)
                                    <li><a href="{{route('showcategory.page', ['lang' => app()->getLocale(), 'category' => $category->id])}}">{{ $category->{'name_' . app()->getLocale()} }}</a></li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">{{ __('messages.Let’s Stay In Touch') }}</h3>
                            <div class="newsletter-widget">
                                <p class="footer-text">{{ __('messages.Subscribe for newsletter') }}</p>
                                <form action="{{ route('newsletter.subscribe', ['lang' => app()->getLocale()]) }}" method="POST" class="newsletter-form">
                                    @csrf
                                    <div class="form-group">
                                        <input class="form-control" type="email" name="email" placeholder="{{ __('messages.Enter Email') }}" required>
                                    </div>
                                    <button type="submit" class="simple-icon"><i class="fa-solid fa-paper-plane"></i></button>
                                </form>
                                <div class="form-group">
                                    <input type="checkbox" id="checkbox" name="checkbox" required>
                                    <label for="checkbox">{{ __('messages.I agree with the terms & conditions') }}</label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap">
            <div class="container">
                <div class="row gy-2 align-items-center">
                    <div class="col-md-7">
                        <p class="copyright-text">Copyright <i class="fal fa-copyright"></i> {{ date('Y') }}  <a href="">glowimplant</a>. All Rights Reserved.</p>
                    </div>
                    <div class="col-md-5 text-center text-md-end">
                        <div class="payment-img">
                            <img src="{{asset('user/assets/img/payment-methods.png')}}" alt="Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--********************************
			Code End  Here 
	******************************** -->

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
        </svg>
    </div>

    <!--==============================
    All Js File
============================== -->
    <!-- Jquery -->
    <script src="{{asset('user/assets/js/vendor/jquery-3.7.1.min.js')}}"></script>
    <!-- Swiper Js -->
    <script src="{{asset('user/assets/js/swiper-bundle.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('user/assets/js/bootstrap.min.js')}}"></script>
    <!-- Magnific Popup -->
    <script src="{{asset('user/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <!-- Counter Up -->
    <script src="{{asset('user/assets/js/jquery.counterup.min.js')}}"></script>
    <!-- datetimepicker -->
    <script src="{{asset('user/assets/js/jquery.datetimepicker.min.js')}}"></script>
    <!-- Range Slider -->
    <script src="{{asset('user/assets/js/jquery-ui.min.js')}}"></script>
    <!-- Isotope Filter -->
    <script src="{{asset('user/assets/js/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{asset('user/assets/js/isotope.pkgd.min.js')}}"></script>
    @yield('script')
    <script src="{{url('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>

        <!-- Message success delete -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                @if(session('success'))
                    Swal.fire({
                        title: "success",
                        text: "{{ session('success') }}",
                        icon: "success",
                        confirmButtonText: "ok"
                    });
                @endif

                @if(session('error'))
                    Swal.fire({
                        title: "error",
                        text: "{{ session('error') }}",
                        icon: "error",
                        confirmButtonText: "close"
                    });
                @endif
            });
        </script>

    <!-- Main Js File -->
    <script src="{{asset('user/assets/js/main.js')}}"></script>
</body>

</html>