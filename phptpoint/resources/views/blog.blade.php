@extends('layouts.main')

@section('title')
    {{ $blog->page_title }}
@endsection

@section('meta_keyword')
    {{ $blog->meta_keyword }}
@endsection

@section('meta_description')
    {{ $blog->meta_description }}
@endsection

@section('page_banner')
	<div style="height: 113px;"></div>
    <div class="unit-5 overlay" style='background-image: url("{{ asset('home/images/hero_1.jpg') }}");'>
      	<div class="container text-center">
        	<h1 class="mb-0">Blogs</h1>
        	<p class="mb-0 unit-6"><a href="/">Home</a> <span class="sep">></span>
               <a href="/blogs">Blogs</a>  <span class="sep">></span> 
             <span>{{ $blog->blog_name }}</span></p>
      	</div>
    </div>
@endsection

@section('content')
	<div class="row">
   		<div class="col-lg-3">
            <div class="p-4 mb-3 bg-white">
             	<div class="list-group">
                    <a href="/blogs" class="list-group-item list-group-item-action active">Blogs </a>
                    @php
                        if(count($recent_blogs)){
                            foreach($recent_blogs as $blog)
                            {
                                @endphp                                 
                                    <a href="/blog/{{ $blog->slug->slug }}" class="list-group-item list-group-item-action ">{{ ucwords($blog->blog_name) }}</a>
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
        <div class="col-md-7 col-lg-7 mb-5 bg-white"> 
        	<div class="p-8 mb-5 bg-white"> 

        		<br>
                <div class="row">
                  <div class="col-md-6 mx-auto text-center mb-5 section-heading">
                    <h2>{{ ucwords($blog->blog_name) }}</h2>
                  </div>
                </div>
                    <div class="row">
                       <div class="col-md-12">
                            @component('components.prev_next')
                                @slot('add','top')
                            @endcomponent 
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
                              {!! $blog->content !!}
                            </div>
                        </div>
                    <div class="clearfix"></div>
                             
                    </div>
            	
            	<div class="clearfix"></div>
                <hr>
                @component('components.prev_next')
                    @slot('add','bottom')
                @endcomponent 
            	
        	</div>          
        </div>   
        <div class="col-md-2">
            @include('components.add')
        </div>       
    </div>
@endsection