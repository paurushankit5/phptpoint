@extends('layouts.main')

@php
  $seo  = App\Seo::where('page_name',"projects")->first();
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
        	<h1 class="mb-0"> Projects </h1>
        	<p class="mb-0 unit-6"><a href="/">Home</a> <span class="sep">></span> <span>Projects</span></p>
      	</div>
    </div>
@endsection

@section('content')
	<div class="row">
   		<div class="col-md-3 col-lg-3">
            <div class="p-4 mb-3 bg-white">
            	<h4 class="text-center text-primary"></h4>
             	<div class="list-group">

				  	@php
              if(count($tutorials)){
                @endphp
                <a href="#" class="list-group-item list-group-item-action active  ">Recent Tutorials</a>
                @php
    			  		foreach($tutorials as $tutorial)
    		  			{
    		  				@endphp				  					
    							<a href="/{{ $tutorial->slug->slug }}" class="list-group-item list-group-item-action  ">{{ $tutorial->tut_name }}</a>
    		  				@php
    		  			}
              }

				  	@endphp
				</div>
                
            </div>
            
        </div>
        <div class="col-md-6 col-lg-6 mb-5 bg-white"> 
        	<div class="p-8 mb-5 bg-white"> 
        		<br>
        		@component('components.prev_next')
                    @slot('add','top')
                @endcomponent 
               
            	<div class="clearfix"></div>
                <div class="row">
                  <div class="col-md-6 mx-auto text-center mb-5 section-heading">
                    <h2>Projects</h2>
                  </div>
                </div>
                @if(count($projects))
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        @php
                          $i=1;
                        @endphp
                      <tr>
                        <th style="width: 10%;">Sr.No.</th>
                        <th>Project</th>
                      </tr> 
                      @foreach($projects as $pro)
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td><a href="/projects/{{ $pro->slug->slug }}">{{ $pro->pro_name }}</a></td>
                        </tr> 
                      @endforeach
                      </table>
                      <div class="clearfix"></div>
                    </div>
                  @endif

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