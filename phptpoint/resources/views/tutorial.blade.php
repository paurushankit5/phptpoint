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

@section('content')
	<div class="row">
   		<div class="col-lg-4">
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
				  	<!-- <a href="/{{ $subtut->slug->slug }}" class="list-group-item list-group-item-action">
				  		<div class="sharethis-inline-share-buttons"></div>
				  	</a> -->
				  	

				</div>
            </div>
            
        </div>
        <div class="col-md-12 col-lg-8 mb-5 bg-white"> 
        	<div class="p-8 mb-5 bg-white"> 
        		<br>
        		@component('components.prev_next')
        			@if(count($tut->subtutorial))
						@slot('next_url',$tut->subtutorial[0]->slug->slug)
					@endif
				@endcomponent       
            	{!! $tut->content !!}
            	<div class="clearfix"></div>
            	@component('components.prev_next')
        			@if(count($tut->subtutorial))
						@slot('next_url',$tut->subtutorial[0]->slug->slug)
					@endif
				@endcomponent 

        	</div>          
        </div>          
    </div>
@endsection