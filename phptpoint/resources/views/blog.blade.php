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
             <span>{{ ucwords($blog->blog_name) }}</span></p>
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
                    <div class="col-md-12">
                        @component('components.prev_next')
                            @slot('add','top')
                            @slot('next_url',$next_slug)
                            @slot('prev_url',$prev_slug)
                        @endcomponent 
                    </div>
                  <div class="col-md-6 mx-auto text-center mb-5 section-heading">
                    
                    <h2>{{ ucwords($blog->blog_name) }}</h2>
                  </div>
                </div>
                    <div class="row">
                       <div class="col-md-12">
                            
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
                    @slot('next_url',$next_slug)
                    @slot('prev_url',$prev_slug)
                @endcomponent 
                <div class="site-section">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-6 mx-auto text-center mb-5 section-heading">
                        <h2 class="mb-5">Latest Blogs</h2>
                      </div>
                    </div>
                    <div class="row form-group">
                        @php
                            $recent_blogs   =   App\Blog::where('status',1)->where('id','<>',$blog->id)->limit(8)->orderBy('id','DESC')->get();
                            if(count($recent_blogs)){
                                foreach ($recent_blogs as $recent_blog) {
                                    @endphp
                                        <div class="col-md-3 col-sm-6 col-xs-6 form-group" >
                                          <div class="media-with-text media-with-text-1" style="border: 1px solid #f7f1f1; padding: 20px; height:200px; border-radius:5px; margin;box-shadow: -2px 10px 22px -16px rgba(0,0,0)">
                                            <div class="img-border-sm mb-4">
                                              <a href="{{ env('APP_URL').'/blog/'.$recent_blog->slug->slug  }}" class="image-play">
                                                <center><img src="{{ asset('images/'.$recent_blog->image) }}" alt="" style="height:100px;" class="img-fluid mx-auto"></center>
                                              </a>
                                            </div>
                                            <h2 class="heading mb-0 h5 text-center"><a href="{{ env('APP_URL').'/blog/'.$recent_blog->slug->slug  }}">{{ $recent_blog->blog_name }}</a></h2>
                                            
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