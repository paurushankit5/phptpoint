@extends('layouts.main')
@php
  $seo  = App\Seo::where('page_name',"blogs")->first();
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
@section('page_banner')
	<div style="height: 113px;"></div>
    <div class="unit-5 overlay" style='background-image: url("{{ asset('home/images/hero_1.jpg') }}");'>
      	<div class="container text-center">
        	<h1 class="mb-0">Blogs</h1>
        	<p class="mb-0 unit-6"><a href="/">Home</a> <span class="sep">></span> <span>Blogs</span></p>
      	</div>
    </div>
@endsection

@section('content')
	<div class="row">
   		<div class="col-lg-3">
           <div class="p-4 mb-3 bg-white">
             	<div class="list-group">
                    <a href="/blogs" class="list-group-item list-group-item-action active">Recent Blogs </a>
                    @php
                    error_reporting(1);
                        if(count($recent_blogs)){
                            foreach($recent_blogs as $recent_blog)
                            {
                                @endphp                                 
                                    <a href="/blog/{{ $recent_blog->slug->slug }}" class="list-group-item list-group-item-action ">{{ ucwords($recent_blog->blog_name) }}</a>
                                @php
                            }
                        }
                    @endphp
                </div>
                @component('components.sidebar')
                    @slot('sidebar_type','blog')
                    @slot('source_page_id',$blog->id)
                @endcomponent
            </div>
        </div>
        
        <div class="col-md-6 col-lg-6 mb-5 bg-white"> 
        	<div class="p-8 mb-5 bg-white"> 
        		<br>
                <div class="row">
                  <div class="col-md-6 mx-auto text-center mb-5 section-heading">
                    <h2>Recent Blogs</h2>
                  </div>
                </div>
        		  @if(count($blogs))
                    <div class="row">
                            @foreach($blogs as $blog)
                        <div class="col-md-4 form-group" style="border:1px solid #CCC;">
                                    <div class="media-with-text">
                                        <div class="img-border-sm mb-4">
                                            <a href="/blog/{{ $blog->slug->slug }}" class="image-play">
                                                <img src="{{asset('images/'.$blog->image)}}" alt="" class="img-fluid">
                                            </a>
                                        </div>
                                      <h2 class="heading mb-0 h5"><a href="/blog/{{ $blog->slug->slug }}">{{ ucwords($blog->blog_name) }}</a></h2>
                                      <span class="mb-3 d-block post-date">{{ date('M Y, d',strtotime($blog->created_at )) }} &bullet;
                                        @if($blog->user) 
                                            By <a href="#">{{ $blog->user->name }} </a>
                                        @endif
                                      </span>
                                    </div>
                                </div>
                            @endforeach
                            <div class="clearfix"></div>
                            {{ $blogs->links()  }}
                             
                    </div>
                  @endif
            	
            	<div class="clearfix"></div>
                @component('components.prev_next')
                    @slot('add','bottom')
                @endcomponent 
            	
        	</div>          
        </div>   
        <div class="col-md-3">
            @include('components.add')
        </div>       
    </div>
@endsection