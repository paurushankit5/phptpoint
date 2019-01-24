<!DOCTYPE html>
<html lang="en">
  <head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="@yield('meta_keyword')" />
    <meta name="description" content="@yield('meta_description')" />

    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700|Work+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('home/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/animate.css') }}">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/mediaelementplayer.min.css">
    
    
    
    <link rel="stylesheet" href="{{ asset('home/fonts/flaticon/font/flaticon.css') }}">
  
    <link rel="stylesheet" href="{{ asset('home/css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('home/css/style.css') }}">
    <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5c45bbc2058f100011a5ac16&product=inline-share-buttons' async='async'></script>
    
  </head>
  <body>
  
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
    
    
    <div class="site-navbar-wrap js-site-navbar bg-white">
      
      <div class="container">
        <div class="site-navbar bg-light">
          <div class="py-1">
            <div class="row align-items-center">
              <div class="col-2">
                <h2 class="mb-0 site-logo"><a href="/">PHP<strong class="font-weight-bold">TPOINT</strong> </a></h2>
              </div>
              <div class="col-10">
                <nav class="site-navigation text-right" role="navigation">
                  <div class="container">
                    <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                        @php
                            $menu   =   App\Http\Controllers\HomeController::getmenubar();
                            if(count($menu['cat']))
                            {
                                foreach($menu['cat'] as $x)
                                {
                                    @endphp
                                        <li class="has-children">
                                            <a href="category.html">{{ $x->cat_name }}</a>
                                            <ul class="dropdown arrow-top">
                                                @php
                                                    if(isset($x->tutorial) && count($x->tutorial))
                                                    {
                                                        foreach($x->tutorial as $tutorial)
                                                        {
                                                            @endphp
                                                                <li><a href="{{ env('APP_URL' )}}/{{ $tutorial->slug->slug }}">{{$tutorial->tut_name}}</a></li>
                                                            @php
                                                        }
                                                    }
                                                @endphp
                                            </ul>
                                          </li>
                                    @php
                                }
                            }
                            if(count($menu['tut']))
                            {
                                foreach($menu['tut'] as $tut)
                                {
                                    @endphp
                                        <li><a href="{{ env('APP_URL' )}}/{{ $tutorial->slug->slug }}">{{$tut->tut_name}}</a></li>
                                    @php
                                }
                            }
                            if(count($menu['free_projects']))
                            {
                              @endphp
                               <li class="has-children">
                                  <a href="category.html">Free Projects</a>
                                  <ul class="dropdown arrow-top">
                              @php
                              foreach($menu['free_projects'] as $pro)
                              {
                                @endphp
                                  <li><a href="{{ env('APP_URL' )}}/projects/{{ $pro->slug->slug }}">{{$pro->pro_name}}</a></li>
                                @php 
                              }
                              @endphp
                                </ul>
                              </li>
                              @php
                            }
                            if(count($menu['about']))
                            {
                              @endphp
                               <li class="has-children">
                                  <a href="category.html">About Us</a>
                                  <ul class="dropdown arrow-top">
                              @php
                              foreach($menu['about'] as $page)
                              {
                                if($page->external_link!='')
                                {
                                  @endphp
                                    <li><a href="{{ $page->external_link }}" target="_blank">{{$page->page_name}}</a></li>
                                  @php
                                }
                                else{
                                  @endphp
                                    <li><a href="{{ env('APP_URL' )}}/{{ $page->slug->slug }}">{{$page->page_name}}</a></li>
                                  @php
                                }                                 
                              }
                              @endphp
                                </ul>
                              </li>
                              @php
                            }
                        @endphp
                      
                      
                      <li><a href="contact.html">Contact</a></li>
                      <li><a href="new-post.html"><span class="bg-primary text-white py-3 px-4 rounded"><span class="icon-plus mr-3"></span>Post New Job</span></a></li>
                    </ul>
                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    @yield('page_banner')

    
    

    <div class="site-section bg-light">
      <div class="container">
            @yield('content')
      </div>
    </div>
    <footer class="site-footer">
      <div class="container">
        

        <div class="row">
          <div class="col-md-4">
            <h3 class="footer-heading mb-4 text-white">About</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat quos rem ullam, placeat amet.</p>
            <p><a href="#" class="btn btn-primary pill text-white px-4">Read More</a></p>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <h3 class="footer-heading mb-4 text-white">Quick Menu</h3>
                  <ul class="list-unstyled">
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Approach</a></li>
                    <li><a href="#">Sustainability</a></li>
                    <li><a href="#">News</a></li>
                    <li><a href="#">Careers</a></li>
                  </ul>
              </div>
              <div class="col-md-6">
                <h3 class="footer-heading mb-4 text-white">Categories</h3>
                  <ul class="list-unstyled">
                    <li><a href="#">Full Time</a></li>
                    <li><a href="#">Freelance</a></li>
                    <li><a href="#">Temporary</a></li>
                    <li><a href="#">Internship</a></li>
                  </ul>
              </div>
            </div>
          </div>

          
          <div class="col-md-2">
            <div class="col-md-12"><h3 class="footer-heading mb-4 text-white">Social Icons</h3></div>
              <div class="col-md-12">
                <p>
                  <a href="#" class="pb-2 pr-2 pl-0"><span class="icon-facebook"></span></a>
                  <a href="#" class="p-2"><span class="icon-twitter"></span></a>
                  <a href="#" class="p-2"><span class="icon-instagram"></span></a>
                  <a href="#" class="p-2"><span class="icon-vimeo"></span></a>

                </p>
              </div>
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy; All Rights Reserved | This template is made with <i class="icon-heart text-warning" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
          </div>
          
        </div>
      </div>
    </footer>
  </div>

  <script src="{{ asset('home/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('home/js/jquery-migrate-3.0.1.min.js') }}"></script>
  <script src="{{ asset('home/js/jquery-ui.js') }}"></script>
  <script src="{{ asset('home/js/popper.min.js') }}"></script>
  <script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('home/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('home/js/jquery.stellar.min.js') }}"></script>
  <script src="{{ asset('home/js/jquery.countdown.min.js') }}"></script>
  <script src="{{ asset('home/js/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ asset('home/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('home/js/aos.js') }}"></script>

  
  <script src="{{ asset('home/js/mediaelement-and-player.min.js') }}"></script>

  <script src="{{ asset('home/js/main.js') }}"></script>
    


     

  </body>
</html>