@extends('layouts.main')

@section('title')
	{{ $subtut->page_title }}
@endsection

@section('meta_keyword')
	{{ $subtut->meta_keyword }}
@endsection

@section('meta_description')
	{{ $subtut->meta_description }}
@endsection

@section('page_banner')
	<div style="height: 113px;"></div>
    <div class="unit-5 overlay" style='background-image: url("{{ asset('home/images/hero_1.jpg') }}");'>
      	<div class="container text-center">
        	<h1 class="mb-0">{{ $subtut->page_name }}</h1>
        	<p class="mb-0 unit-6"><a href="/">Home</a> <span class="sep">></span> <span> <a href="/{{ $subtut->tutorial->slug->slug }}">{{ $subtut->tutorial->tut_name }}</a> <span class="sep">></span> <span> {{ $subtut->subtut_name }}</span></p>
      	</div>
    </div>
@endsection

@section('content')
	<div class="row">
   		<div class="col-lg-4">
            <div class="p-4 mb-3 bg-white">
             	<div class="list-group">
				  	<a href="/{{$subtut->tutorial->slug->slug}}" class="list-group-item list-group-item-action">{{ $subtut->tutorial->tut_name }} </a>
				  	@php
				  		foreach($subtut->tutorial->subtutorial as $subtut1)
			  			{
			  				@endphp				  					
								<a href="/{{ $subtut1->slug->slug }}" class="list-group-item list-group-item-action  @if( $subtut1->id == $subtut->id ) active @endif">{{ $subtut1->subtut_name }}</a>
			  				@php
			  			}

				  	@endphp
				</div>
				@component('components.sidebar')
			  		@slot('sidebar_type','tutorial')
			  		@slot('source_page_id',$subtut->id)
			  	@endcomponent
            </div>
            
        </div>
        <div class="col-md-12 col-lg-8 mb-5 bg-white"> 
        	<div class="p-8 mb-5 bg-white"> 
        		<br>
        		@component('components.prev_next')
					@slot('next_url',$next_slug)
					@slot('prev_url',$prev_slug)
				@endcomponent       
            	{!! $subtut->content !!}
            	<div class="clearfix"></div>
            	@component('components.prev_next')
					@slot('next_url',$next_slug)
					@slot('prev_url',$prev_slug)					
				@endcomponent 
        	</div>          
        </div>          
    </div>
@endsection