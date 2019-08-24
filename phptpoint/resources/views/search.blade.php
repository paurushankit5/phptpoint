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
    <div class="unit-5 overlay" style='background-image: url("{{ asset('home/images/hero_1.jpg') }}");'>
        <div class="container text-center">
          <h1 class="mb-0">Search</h1>
            @include('components.search')
        </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mx-auto text-center mb-5 section-heading">
            <h2 class="mb-5">Search Results</h2>
          </div>
        </div>
        <div class="row">
            @php
                if(count($search_tutorial)){
                    foreach ($search_tutorial as $tut) {
                        @endphp
                            <div class="col-md-3" >
                              <div class="media-with-text media-with-text-1" style="border: 1px solid gray; padding: 20px; border-radius: 10px; margin">
                                <div class="img-border-sm mb-4">
                                  <a href="{{ env('APP_URL').'/'.$tut->slug->slug  }}" class="image-play">
                                    <img src="{{ asset('images/'.$tut->image) }}" style="height:200px; width: 100%;" alt="" class="img-fluid">
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
        <div class="row">
          <div class="col-md-12">
            @if(count($search_subtutorial))
              <br>
              <br>
              <br>
              <br>
              <ul class="list-group">
                <li class="list-group-item active bg-primary">{{ count($search_tutorial) ? 'Some More Results' : 'Search Results' }} </li>
              @foreach($search_subtutorial as $subtutorial)
                <li class="list-group-item"><a href="/{{ $subtutorial->slug->slug }}">{{ $subtutorial->subtut_name }}</a></li>
              @endforeach
              </ul>
            @endif
          </div>

        </div>
      </div>
    </div>
    
  
    
@endsection
@section('after_scripts')
  @include('components.search_js')
@endsection