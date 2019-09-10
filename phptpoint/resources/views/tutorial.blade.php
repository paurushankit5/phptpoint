@extends('layouts.main')

@section('title')
	{{ $tut->page_title }}
@endsection

@section('meta_keyword')
	{{ $tut->meta_keyword }}
@endsection

@section('meta_description')
	{{ $tut->meta_description }}
@endsection

@section('page_banner')
	<div style="height: 113px;"></div>
    <div class="unit-5 overlay" style='background-image: url("{{ asset('home/images/hero_1.jpg') }}");'>
      	<div class="container text-center">
        	<h1 class="mb-0">{{ $tut->page_name }}</h1>
        	<p class="mb-0 unit-6"><a href="/">Home</a> <span class="sep">></span> <span>{{ $tut->tut_name }}</span></p>
      	</div>
    </div>
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

@section('content')
	<div class="row">
   		<div class="col-md-3 col-lg-3">
            <div class="p-4 mb-3 bg-white">
             	<div class="list-group">
				  	<a href="/{{$tut->slug->slug}}" class="list-group-item list-group-item-action active">{{ $tut->tut_name }} </a>
				  	@php
				  		if(count($tut->subtutorial))
				  		{
				  			foreach($tut->subtutorial as $subtut)
				  			{
				  				@endphp				  					
									<a href="/{{ $subtut->slug->slug }}" class="list-group-item list-group-item-action">{{ $subtut->subtut_name }}</a>
				  				@php
				  			}
				  		}

				  	@endphp

				  	@component('components.sidebar')
				  		@slot('sidebar_type','tutorial')
				  		@slot('source_page_id',$tut->id)
				  	@endcomponent
				  	

				</div>
            </div>
            
        </div>
        <div class="col-md-6 col-lg-6 mb-5 bg-white"> 
        	<div class="p-8 mb-5 bg-white"> 
        		<br>
        		@component('components.prev_next')
        			@if(count($tut->subtutorial))
						@slot('next_url',$tut->subtutorial[0]->slug->slug)
					@endif
                    @slot('add','top')
                @endcomponent  
                @if($tut->zip_name !='')
                    <p><b>Total Downloads : {{$tut->downloads->count()}}</b></p>
                    <hr>
                @endif    
            	{!! $tut->content !!}
            	@if($tut->zip_name !='' )
                    <div class="col-md-12 text-center">
                        <br>
                        <br>
                        @guest
                            <a href="/loginToDownload/{{$tut->slug->slug}}/{{ $tut->id }}?page=tutorial" class="btn btn-primary btn-download"> Login / Register To Download</a>
                        @else
                            <a href="/gettutorialfile/{{$tut->slug->slug}}/{{ $tut->id }}" class="btn btn-primary btn-download"> Click Here To Download</a>
                        @endguest
                    </div>
                @endif
            	<div class="clearfix"></div>
            	@component('components.prev_next')
        			@if(count($tut->subtutorial))
						@slot('next_url',$tut->subtutorial[0]->slug->slug)

					@endif
                    @slot('add','bottom')
				@endcomponent 
        	</div>
        	
            <div class="site-section">
              <div class="container">
                <div class="row">
                  <div class="col-md-6 mx-auto text-center mb-5 section-heading">
                    <h2 class="mb-5">Learn Latest Tutorials</h2>
                  </div>
                </div>
                <div class="row form-group">
                    @php
                        $page_tutorials   =   App\Tutorial::where('status',1)->limit(8)->orderBy('id','DESC')->get();
                        if(count($page_tutorials)){
                            foreach ($page_tutorials as $tut) {
                                @endphp
                                    <div class="col-md-3 col-sm-6 col-xs-6 form-group" >
                                      <div class="media-with-text media-with-text-1" style="border: 1px solid #f7f1f1; padding: 20px; height:200px; border-radius:5px; margin;box-shadow: -2px 10px 22px -16px rgba(0,0,0)">
                                        <div class="img-border-sm mb-4">
                                          <a href="{{ env('APP_URL').'/'.$tut->slug->slug  }}" class="image-play">
                                            <center><img src="{{ asset('images/'.$tut->image) }}" style="height: 100px;" alt="" class="img-fluid mx-auto"></center>
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
        </div>  
        <div class="col-md-3">
          	@include('components.add')
        </div>        
    </div>
@endsection
