@extends('layouts.main')

@section('title')
	{{ $pro->page_title }}
@endsection

@section('meta_keyword')
	{{ $pro->meta_keyword }}
@endsection

@section('meta_description')
	{{ $pro->meta_description }}
@endsection

@section('page_banner')
	<div style="height: 113px;"></div>
    <div class="unit-5 overlay" style='background-image: url("{{ asset('home/images/hero_1.jpg') }}");'>
      	<div class="container text-center">
        	<h1 class="mb-0">{{ $pro->page_name }}</h1>
        	<p class="mb-0 unit-6"><a href="/">Home</a> <span class="sep">></span> <span> {{ $pro->pro_name }}</span></p>
      	</div>
    </div>
@endsection

@section('content')
	<div class="row">
   		<div class="col-md-3 col-lg-3">
            <div class="p-4 mb-3 bg-white">
            	<h4 class="text-center text-primary">@if($pro->is_paid == 0) Free @else Paid @endif Projects</h4>
             	<div class="list-group">
				  	@php
				  		foreach($projects as $project)
			  			{
			  				@endphp				  					
								<a href="/projects/{{ $project->slug->slug }}" class="list-group-item list-group-item-action  @if( $pro->id == $project->id ) active @endif">{{ $project->pro_name }}</a>
			  				@php
			  			}

				  	@endphp
				</div>
                @component('components.sidebar')
                    @slot('sidebar_type','project')
                    @slot('source_page_id',$project->id)
                @endcomponent
            </div>
            
        </div>
        <div class="col-md-6 col-lg-6 mb-5 bg-white"> 
        	<div class="p-8 mb-5 bg-white"> 
        		<br>
        		@component('components.prev_next')
                    @slot('add','top')
                @endcomponent 
               
            	{!! $pro->content !!}
            	<div class="clearfix"></div>
                @if($project->video_url !='')
                    <h4 class="text text-center">Downloading and installation Steps</h4>
                    <iframe  src="<?= $project->video_url; ?>" style="width: 100%;min-height:400px;" frameborder="0" allowfullscreen></iframe>
                @endif
                @if($pro->is_paid == 0 && $pro->zip_name !='' )
                    <div class="col-md-12 text-center">
                     
                     @if($pro->zip_name !='')
                    <p class="btn btn-primary"><b>Total Downloads : {{$pro->downloads->count()}}</b></p>
                    @endif
                        @guest
                            <a href="/loginToDownload/projects/{{$pro->slug->slug}}" class="btn btn-primary btn-download"> Login / Register To Download</a>
                        @else
                            <a href="/getprojectfile/{{ $pro->id }}" class="btn btn-primary btn-download"> Click Here To Download</a>
                        @endguest
                    </div>
                @endif
                @component('components.prev_next')
                    @slot('add','bottom')
                @endcomponent 
                <div class="site-section">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-6 mx-auto text-center mb-5 section-heading">
                        <h2 class="mb-5">Other Free Latest Projects</h2>
                      </div>
                    </div>
                    <div class="row form-group">
                        @php
                            $recent_projects   =   App\Project::where('is_paid',0)->where('id','<>',$pro->id)->limit(16)->orderBy('id','DESC')->get();
                            if(count($recent_projects)){
                                foreach ($recent_projects as $recent_project) {
                                    @endphp
                                        <div class="col-md-3 col-sm-6 col-xs-6 form-group" >
                                          <div class="media-with-text media-with-text-1" style="border: 1px solid #f7f1f1; padding: 20px; height:120px; border-radius:5px; margin;box-shadow: -2px 10px 22px -16px rgba(0,0,0)">
                                            <div class="img-border-sm mb-4">
                                              <a href="{{ env('APP_URL').'/projects/'.$recent_project->slug->slug  }}" class="image-play">
                                                <center><img src="{{ asset('images/projects/'.$recent_project->pro_image) }}" alt="" style="height:80px;width:80px" title="Download {{ $recent_project->pro_name }}" class="img-fluid mx-auto"></center>
                                              </a>
                                            </div>
                                            
                                        <!--
                                        <h2 class="heading mb-0 h5 text-center"><a href="{{ env('APP_URL').'/projects/'.$recent_project->slug->slug  }}">{{ $recent_project->pro_name }}</a></h2>
                                        -->    
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
        </div>      
        <div class="col-md-3">
            @include('components.add')
        </div>    
    </div>
@endsection