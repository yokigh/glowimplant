
<div class="sidemenu-wrapper sidemenu-info ">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget  ">
                <div class="th-widget-about">
                    <div class="about-logo">
                        <a href="home-medical-clinic.html"><img src="{{asset('assets/images/logo/logo.png')}}" alt="glow implant"></a>
                    </div>
                    <p class="about-text">Subscribe to out newsletter today to receive latest news administrate cost effective for tactical data.</p>
                    <p class="footer-info">
                        <i class="fal fa-location-dot"></i>
                        2478 Street City Ohio 90255
                    </p>
                    <p class="footer-info">
                        <i class="fal fa-envelope"></i>
                        <a href="mailto:info@mediax.com" class="info-box_link">info@mediax.com</a>
                    </p>
                    <p class="footer-info">
                        <i class="fal fa-phone"></i>
                        <a href="tel:+40276328246" class="info-box_link">+(402) 763 282 46</a>
                    </p>
                    <div class="th-social">
                        <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Let’s Stay In Touch</h3>
                <div class="newsletter-widget">
                    <p class="footer-text">Subscribe for newsletter</p>
                    <form action="#" class="newsletter-form">
                        <div class="form-group">
                            <input class="form-control" type="email" placeholder="Enter Email" required="">
                        </div>
                        <button type="submit" class="simple-icon"><i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                    <div class="form-group">
                        <input type="checkbox" id="checkboxagree" name="checkboxagree">
                        <label for="checkboxagree">I agree with the terms & conditions</label>
                    </div>
                    <div class="btn-group">
                        <a href="https://play.google.com/" class="img-btn">
                            <img src="{{asset('assets/img/normal/apple_store.png')}}" alt="icon">
                        </a>
                        <a href="https://play.google.com/" class="img-btn">
                            <img src="{{asset('assets/img/normal/play_store.png')}}" alt="icon">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-search-box d-none d-lg-block">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" placeholder="What are you looking for?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div><!--==============================
    Mobile Menu
  ============================== -->
    <div class="th-menu-wrapper">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="home-medical-clinic.html"><img src="{{asset('assets/images/logo/logo.png')}}" alt="glow implant"></a>
            </div>
            <div class="th-mobile-menu">
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
            </div>
        </div>
    </div>