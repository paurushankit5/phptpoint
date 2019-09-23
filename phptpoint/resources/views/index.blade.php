@extends('layouts.main')
@php
  $seo  = App\Seo::where('page_name',"homepage")->first();
@endphp
@section('title')
  @if(!empty($seo->page_title)) {{$seo->page_title}} @endif
@endsection

@section('meta_keyword')
     @if(!empty($seo->meta_keyword)) {{$seo->meta_keyword}} @endif
@endsection

@section('meta_description')
     @if(!empty($seo->meta_description)) {{$seo->meta_description}} @endif
@endsection

@section('header_style')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style type="text/css">
    .media-with-text-1{
      transition: transform .2s;
    }
    .media-with-text-1:hover {
      transform: scale(1.2); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }
  </style>
@endsection

@section('page_banner')
     <div style="height: 113px;"></div>

    <div class="site-blocks-cover overlay" style='background-image: url("{{ asset('home/images/hero_1.jpg') }}");' data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-12" data-aos="fade">
            <!--<h1>PHPTPOINT</h1>-->
            @include('components.search')
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mx-auto text-center mb-5 section-heading">
            <h2 class="mb-5">Popular Tutorials</h2>
          </div>
        </div>
        <div class="row form-group">
            @php
                if(count($tutorial)){
                    foreach ($tutorial as $tut) {
                        @endphp
                            <div class="col-md-3 col-sm-6 col-xs-6 form-group" style="margin-bottom: 50px;" >
                              <div class="media-with-text media-with-text-1" style="border: 1px solid #f7f1f1; padding: 20px; border-radius:5px; margin;box-shadow: -2px 10px 22px -16px rgba(0,0,0)">
                                <div class="img-border-sm mb-4">
                                  <a href="{{ env('APP_URL').'/'.$tut->slug->slug  }}" class="image-play">
                                    <center><img src="{{ asset('images/'.$tut->image) }}" style="height:100px; width: 100px;" alt="" class="img-fluid mx-auto"></center>
                                  </a>
                                </div>
                                <h2 class="heading mb-0 h5 text-center"><a href="{{ env('APP_URL').'/'.$tut->slug->slug  }}">{{ $tut->tut_name }}</a></h2>
                                
                              </div>
                            </div>
                        @php
                    }
                }
            @endphp
        </div>
      </div>
    </div>
    
     <div class="site-section bg-light">
      <div class="container">
        <div class="row form-group">
          <div class="col-md-6 mb-5 mb-md-0" data-aos="fade-up" data-aos-delay="100">
            <h3 class="mb-5 h3">Recent Tutorials</h3>
            <div class="rounded border jobs-wrap">
              @php
                $recent_tutorials = App\Tutorial::where('status',1)->limit(5)->orderBy('id','DESC')->get();
              @endphp
              @if(count($recent_tutorials))
                @foreach($recent_tutorials as $recent_tutorial)
                  <a href="/{{ $recent_tutorial->slug->slug }}" class="job-item d-block d-md-flex align-items-center partime">
                    <div class="company-logo blank-logo text-center text-md-left pl-3">
                      <img src="{{ asset('home/images/logo_2.png') }}" alt="Image" class="img-fluid mx-auto">
                    </div>
                    <div class="job-details h-100">
                      <div class="p-3 align-self-center">
                        <h3>{{ $recent_tutorial->tut_name }}</h3>
                        <div class="d-block d-lg-flex">
                          <div class="mr-3"><span class="icon-suitcase mr-1"></span> {{ date('d-M-Y', strtotime($recent_tutorial->created_at)) }}</div>
                        </div>
                      </div>
                    </div>
                    <div class="job-category align-self-center">
                      <div class="p-3">
                        <span class="text-danger p-2 rounded border border-danger">View</span>
                      </div>
                    </div>  
                  </a>
                @endforeach
              @endif
            </div>
          </div>
          <div class="col-md-6 mb-5 mb-md-0" data-aos="fade-up" data-aos-delay="100">
            <h3 class="mb-5 h3">Recent Topics</h3>
            <div class="rounded border jobs-wrap">
              @php
                $recent_subtuts = App\Subtutorial::where('status',1)->limit(10)->orderBy('id','DESC')->get();
              @endphp
              @if(count($recent_subtuts))
                @foreach($recent_subtuts as $recent_subtut)
                  <a href="/{{ $recent_subtut->slug->slug }}" class="job-item d-block d-md-flex align-items-center partime">
                    <!-- <div class="company-logo blank-logo text-center text-md-left pl-3">
                      <img src="{{ asset('home/images/logo_2.png') }}" alt="Image" class="img-fluid mx-auto">
                    </div> -->
                    <div class=" h-100">
                      <div class="align-self-center" style="padding-left: 15px;">
                        <h3>{{ $recent_subtut->subtut_name }}</h3>
                        <div class="d-block d-lg-flex">
                          <div class="mr-3"><span class="icon-suitcase mr-1"></span> {{ date('d-M-Y', strtotime($recent_subtut->created_at)) }}</div>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="job-category align-self-center">
                      <div class="p-3">
                        <span class="text-danger p-2 rounded border border-danger">View</span>
                      </div>
                    </div>  --> 
                  </a>
                @endforeach
              @endif
            </div>
          </div>
          
        
        </div>
      </div>
    </div>
     <div class="site-section" data-aos="fade">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 mb-5 mb-md-0">
            
              <div class="img-border">
                <a href="https://vimeo.com/28959265" class="popup-vimeo image-play">
                  <span class="icon-wrap">
                    <span class="icon icon-play"></span>
                  </span>
                  <img src="{{ asset('home/images/hero_2.jpg') }}" alt="Image" class="img-fluid rounded">
                </a>
              </div>
            
          </div>
          <div class="col-md-5 ml-auto">
            <div class="text-left mb-5 section-heading">
              <h2>Testimonies</h2>
            </div>

            <p class="mb-4 h5 font-italic lineheight1-5">&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque, nisi Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit nobis magni eaque velit eum, id rem eveniet dolor possimus voluptas..&rdquo;</p>
            <p>&mdash; <strong class="text-black font-weight-bold">John Holmes</strong>, Marketing Strategist</p>
            <p><a href="https://vimeo.com/28959265" class="popup-vimeo text-uppercase">Watch Video <span class="icon-arrow-right small"></span></a></p>
          </div>
        </div>
      </div>
    </div>
   <!--  <div class="site-blocks-cover overlay inner-page" style='background-image: url("{{ asset('images/hero_1.jpg') }}");' data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-6 text-center" data-aos="fade">
            <h1 class="h3 mb-0">Your Dream Career</h1>
            <p class="h3 text-white mb-5">Is Waiting For You</p>
            <p><a href="#" class="btn btn-outline-warning py-3 px-4">Find Jobs</a> <a href="#" class="btn btn-warning py-3 px-4">Apply For A Job</a></p>
            
          </div>
        </div>
      </div>
    </div> -->
    <div class="site-section site-block-feature bg-light">
      <div class="container">
        
        <div class="text-center mb-5 section-heading">
          <h2>Why Choose Us</h2>
        </div>

        <div class="d-block d-md-flex border-bottom">
          <div class="text-center p-4 item border-right" data-aos="fade">
            <span class="flaticon-worker display-3 mb-3 d-block text-primary"></span>
            <h2 class="h4">More Jobs Every Day</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati reprehenderit explicabo quos fugit vitae dolorum.</p>
            <p><a href="#">Read More <span class="icon-arrow-right small"></span></a></p>
          </div>
          <div class="text-center p-4 item" data-aos="fade">
            <span class="flaticon-wrench display-3 mb-3 d-block text-primary"></span>
            <h2 class="h4">Creative Jobs</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati reprehenderit explicabo quos fugit vitae dolorum.</p>
            <p><a href="#">Read More <span class="icon-arrow-right small"></span></a></p>
          </div>
        </div>
        <div class="d-block d-md-flex">
          <div class="text-center p-4 item border-right" data-aos="fade">
            <span class="flaticon-stethoscope display-3 mb-3 d-block text-primary"></span>
            <h2 class="h4">Healthcare</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati reprehenderit explicabo quos fugit vitae dolorum.</p>
            <p><a href="#">Read More <span class="icon-arrow-right small"></span></a></p>
          </div>
          <div class="text-center p-4 item" data-aos="fade">
            <span class="flaticon-calculator display-3 mb-3 d-block text-primary"></span>
            <h2 class="h4">Finance &amp; Accounting</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati reprehenderit explicabo quos fugit vitae dolorum.</p>
            <p><a href="#">Read More <span class="icon-arrow-right small"></span></a></p>
          </div>
        </div>
      </div>
    </div>

    


    <div class="site-section block-15">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mx-auto text-center mb-5 section-heading">
            <h2>Recent Free Projects</h2>
          </div>
        </div>

        @php
          $recent_projects   =   App\Project::where('pro_image','<>','')->limit(12)->orderBy('id','DESC')->get();
        @endphp
        <div class="nonloop-block-15 owl-carousel">
            @if(count($recent_projects))
              @foreach($recent_projects as $recent_project)
                <div class="media-with-text panel">
                  <div class="img-border-sm mb-4" style="">
                    <a href="/projects/{{ $recent_project->slug->slug }}" class="image-play">
                      @if($recent_project->pro_image)
                          <img src="{{ asset('images/projects/'.$recent_project->pro_image) }}" alt="{{ $recent_project->pro_name }}" style="height:150px;width:150px" class="img-fluid">
                        @endif
                    </a>
                  </div>
                  <h3 class="heading mb-0 h5"><a href="#">{{ $recent_project->pro_name }}</a></h3>
                  <span class="mb-3 d-block post-date">{{ date('d-M-Y', strtotime($recent_project->created_at)) }} </span>
                  <br>
                  <!--<p>{!! substr($recent_project->content,0,150) !!}</p>-->
                  <p class="text-center"><a href="/projects/{{ $recent_project->slug->slug }}" class="btn btn-danger btn-lg ">Download  </a></p>
                </div>
              @endforeach 
            @endif

                
          
            <!-- <div class="media-with-text">
              <div class="img-border-sm mb-4">
                <a href="#" class="image-play">
                  <img src="{{ asset('home/images/img_2.jpg') }}" alt="" class="img-fluid">
                </a>
              </div>
              <h2 class="heading mb-0 h5"><a href="#">Jobs are made easy</a></h2>
              <span class="mb-3 d-block post-date">January 20, 2018 &bullet; By <a href="#">Josh Holmes</a></span>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis veritatis tempora natus rerum obcaecati.</p>
            </div>
          
            <div class="media-with-text">
              <div class="img-border-sm mb-4">
                <a href="#" class="image-play">
                  <img src="{{ asset('home/images/img_3.jpg') }}" alt="" class="img-fluid">
                </a>
              </div>
              <h2 class="heading mb-0 h5"><a href="#">Jobs are made easy</a></h2>
              <span class="mb-3 d-block post-date">January 20, 2018 &bullet; By <a href="#">Josh Holmes</a></span>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis veritatis tempora natus rerum obcaecati.</p>
            </div>

            <div class="media-with-text">
              <div class="img-border-sm mb-4">
                <a href="#" class="image-play">
                  <img src="{{ asset('home/images/img_1.jpg') }}" alt="" class="img-fluid">
                </a>
              </div>
              <h2 class="heading mb-0 h5"><a href="#">Jobs are made easy</a></h2>
              <span class="mb-3 d-block post-date">January 20, 2018 &bullet; By <a href="#">Josh Holmes</a></span>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis veritatis tempora natus rerum obcaecati.</p>
            </div>
          
            <div class="media-with-text">
              <div class="img-border-sm mb-4">
                <a href="#" class="image-play">
                  <img src="{{ asset('home/images/img_2.jpg') }}" alt="" class="img-fluid">
                </a>
              </div>
              <h2 class="heading mb-0 h5"><a href="#">Jobs are made easy</a></h2>
              <span class="mb-3 d-block post-date">January 20, 2018 &bullet; By <a href="#">Josh Holmes</a></span>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis veritatis tempora natus rerum obcaecati.</p>
            </div>
          
            <div class="media-with-text">
              <div class="img-border-sm mb-4">
                <a href="#" class="image-play">
                  <img src="{{ asset('home/images/img_3.jpg') }}" alt="" class="img-fluid">
                </a>
              </div>
              <h2 class="heading mb-0 h5"><a href="#">Jobs are made easy</a></h2>
              <span class="mb-3 d-block post-date">January 20, 2018 &bullet; By <a href="#">Josh Holmes</a></span>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis veritatis tempora natus rerum obcaecati.</p>
            </div>
            
            <div class="media-with-text">
              <div class="img-border-sm mb-4">
                <a href="#" class="image-play">
                  <img src="{{ asset('home/images/img_1.jpg') }}" alt="" class="img-fluid">
                </a>
              </div>
              <h2 class="heading mb-0 h5"><a href="#">Jobs are made easy</a></h2>
              <span class="mb-3 d-block post-date">January 20, 2018 &bullet; By <a href="#">Josh Holmes</a></span>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis veritatis tempora natus rerum obcaecati.</p>
            </div>
          
            <div class="media-with-text">
              <div class="img-border-sm mb-4">
                <a href="#" class="image-play">
                  <img src="{{ asset('home/images/img_2.jpg') }}" alt="" class="img-fluid">
                </a>
              </div>
              <h2 class="heading mb-0 h5"><a href="#">Jobs are made easy</a></h2>
              <span class="mb-3 d-block post-date">January 20, 2018 &bullet; By <a href="#">Josh Holmes</a></span>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis veritatis tempora natus rerum obcaecati.</p>
            </div>
          
            <div class="media-with-text">
              <div class="img-border-sm mb-4">
                <a href="#" class="image-play">
                  <img src="{{ asset('home/images/img_3.jpg') }}" alt="" class="img-fluid">
                </a>
              </div>
              <h2 class="heading mb-0 h5"><a href="#">Jobs are made easy</a></h2>
              <span class="mb-3 d-block post-date">January 20, 2018 &bullet; By <a href="#">Josh Holmes</a></span>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio dolores culpa qui aliquam placeat nobis veritatis tempora natus rerum obcaecati.</p>
            </div> -->
        </div>

        <div class="row">
          
        </div>
      </div>
    </div>
    
@endsection
@section('after_scripts')
  @include('components.search_js')
@endsection