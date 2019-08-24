@extends('layouts.main')

@section('title')
@endsection

@section('meta_keyword')
@endsection

@section('meta_description')
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
   		<!-- <div class="col-lg-3">
            <div class="p-4 mb-3 bg-white">
             	
            </div>
            
        </div> -->
        <div class="col-md-10 col-lg-10 mb-5 bg-white"> 
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
                                 <div class="col-md-6">

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
                                    <hr>
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
        <div class="col-md-2">
            @include('components.add')
        </div>       
    </div>
@endsection