@extends('layouts.main')

@section('title')
	{{ $page->page_title }}
@endsection

@section('meta_keyword')
	{{ $page->meta_keyword }}
@endsection

@section('meta_description')
	{{ $page->meta_description }}
@endsection

@section('page_banner')
	<div style="height: 113px;"></div>
    <div class="unit-5 overlay" style='background-image: url("{{ asset('home/images/hero_1.jpg') }}");'>
      	<div class="container text-center">
        	<h1 class="mb-0">{{ $page->page_name }}</h1>
        	<p class="mb-0 unit-6"><a href="/">Home</a> <span class="sep">></span> <span> {{ $page->page_name }}</span></p>
      	</div>
    </div>
@endsection

@section('content')
	<div class="row">
   		<div class="col-lg-4">
            <div class="p-4 mb-3 bg-white">
             	@component('components.sidebar')
                    @slot('sidebar_type','page')
                    @slot('source_page_id',$page->id)
                @endcomponent
            </div>
            
        </div>
        <div class="col-md-12 col-lg-8 mb-5 bg-white"> 
        	<div class="p-8 mb-5 bg-white"> 
        		<br>
        		      
            	{!! $page->content !!}
            	<div class="clearfix"></div>
                
            	
        	</div>          
        </div>          
    </div>
@endsection