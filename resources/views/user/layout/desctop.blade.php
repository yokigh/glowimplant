
<header class="th-header header-layout2">
        <div class="menu-top">
            <div class="container">
                <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
                    <div class="col-auto d-none d-lg-block">
                        <div class="header-logo">
                            <a href="home-medical-clinic.html"><img src="{{asset('assets/images/logo/logo.png')}}" style="width:150px;" alt="Mediax"></a>
                        </div>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <div class="info-card-wrap">
                            <div class="info-card">
                                <div class="box-icon">
                                    <i class="fal fa-headset"></i>
                                </div>
                                <div class="box-content">
                                    <p class="box-text">{{ __("messages.Contact Us") }}</p>
                                    <h4 class="box-title"><a href="tel:+1636543569">+163-654-3569</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <div class="menu-area">
                <div class="container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto d-none d-lg-inline-block">
                            <nav class="main-menu menu-style1">
                                <ul>
                                    <li class="menu-item">
                                        <a href="{{route('home.page', ['lang' => app()->getLocale()])}}">{{ __('messages.Home') }}</a>
                                    </li>
                                    <li><a href="{{route('about.page', ['lang' => app()->getLocale()])}}">{{ __('messages.About Us') }}</a></li>
                                                    
                                    @foreach ($layoutcategories as $category)
                                        
                                        <li class="menu-item-has-children">
                                            <a href="{{route('showcategory.page', ['lang' => app()->getLocale(), 'category' => $category->id])}}">{{ $category->{'name_' . app()->getLocale()} }}</a>
                                            @if($category->subcategories->count() > 0)
                    
                                            <ul class="sub-menu">
                                            @foreach($category->subcategories as $subcategory)
                                            <li>
                                                <a href="{{route('showsubcategory.page', ['lang' => app()->getLocale(), 'subcategory' => $subcategory->id])}}">{{ $subcategory->{'name_' . app()->getLocale()} }}</a>
                                            </li>
                                        @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        
                                        @endforeach 
                                   
                                    <li>
                                        <a href="{{route('event.page', ['lang' => app()->getLocale()])}}">{{ __('messages.Event') }}</a>
                                    </li>
                                    <li>
                                        <a href="{{route('contact.page', ['lang' => app()->getLocale()])}}">{{ __('messages.Contact') }}</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-auto d-inline-block d-lg-none">
                            <div class="header-logo" style="background:#fff;paddin:8px;border-radius: 12px;">
                                <a href="home-medical-clinic.html"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Mediax"></a>
                            </div>
                        </div>
                        <div class="col-auto ms-auto">
                            <div class="header-button">
                            @php
    use Illuminate\Support\Str;

    // اللغات المتاحة وصور الأعلام
    $languages = [
        'en' => ['name' => 'English', 'flag' => 'us.jpg'],
        'de' => ['name' => 'German', 'flag' => 'germany.jpg'],
        'fr' => ['name' => 'French', 'flag' => 'french.jpg'],
        'ar' => ['name' => 'Arabic', 'flag' => 'arabic.png'],
        'es' => ['name' => 'Spanish', 'flag' => 'spain.jpg'],
    ];

    // الحصول على اللغة الحالية من الرابط
    $currentLang = app()->getLocale();
    $currentUrl = url()->current();

    // استبدال اللغة الحالية باللغات الأخرى
    function getLangUrl($newLang, $currentLang, $currentUrl) {
        if (preg_match('/\/(en|de|fr|es|ar)\//', $currentUrl)) {
            return Str::replaceFirst("/$currentLang/", "/$newLang/", $currentUrl);
        } else {
            return url($newLang);
        }
    }
@endphp

<div class="dropdown-link d-none d-lg-inline-block">
    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="true">
        <img src="{{ asset('assets/images/flags/' . $languages[$currentLang]['flag']) }}" style="width: 35px;" alt="icon"> 
        {{ $languages[$currentLang]['name'] }}
    </a>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
        @foreach ($languages as $lang => $data)
            @if ($lang !== $currentLang) <!-- تجنب عرض اللغة الحالية -->
                <li>
                    <a href="{{ getLangUrl($lang, $currentLang, $currentUrl) }}">
                        <img src="{{ asset('assets/images/flags/' . $data['flag']) }}" alt="icon"> 
                        {{ $data['name'] }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>

                                @auth
                                <div class="dropdown">
                                    <button class="icon-btn sideMenuCart dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-user"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="userMenu">
                                        <li><a class="dropdown-item" href="{{ route('getcart.view', ['lang' => app()->getLocale()]) }}"><i class="fa-solid fa-shopping-cart"></i> Cart</a></li>
                                        <li><a class="dropdown-item" href=""><i class="fa-solid fa-user"></i> payment</a></li>
                                        <li><a class="dropdown-item" href=""><i class="fa-solid fa-user"></i> Profile</a></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item"><i class="fa-solid fa-sign-out-alt"></i> Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                    
                                @else
                                <a href="{{ route('getcart.view', ['lang' => app()->getLocale()]) }}" class="icon-btn sideMenuCart">
                                    
                                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                </a>
                                @endauth
                                <a href="" class="icon-btn ">
                                    <i class="fal fa-cart-shopping"></i>
                                </a>
                                <a href="wishlist.html" class="icon-btn d-none d-lg-inline-block">
                                    <span class="badge">3</span>
                                    <i class="fal fa-heart"></i>
                                </a>
                                <button type="button" class="icon-btn sideMenuInfo d-none d-lg-inline-block"><i class="fal fa-bars"></i></button>
                                <button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>