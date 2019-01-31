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
   		<div class="col-lg-4">
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
        <div class="col-md-12 col-lg-8 mb-5 bg-white"> 
        	<div class="p-8 mb-5 bg-white"> 
        		<br>
        		      
            	{!! $pro->content !!}
            	<div class="clearfix"></div>
                @if($project->video_url !='')
                    <h4 class="text text-center">Downloading and installation Steps</h4>
                    <iframe  src="<?= $project->video_url; ?>" style="width: 100%;min-height:400px;" frameborder="0" allowfullscreen></iframe>
                @endif
                @if($pro->is_paid == 0 && $pro->zip_name !='')
                    <div class="col-md-12 text-center">
                        <br>
                        <br>
                        <a href="/getprojectfile/{{$pro->slug->slug}}/{{ $pro->id }}" class="btn btn-primary btn-download"> Click Here To Download</a>
                    </div>
                @endif
            	
        	</div>          
        </div>          
    </div>
@endsection