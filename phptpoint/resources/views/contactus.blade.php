@extends('layouts.main')
@php
  $seo  = App\Seo::where('page_name',"contactus")->first();
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

@section('header_style')
  <style type="text/css">
    .media-with-text-1{
      transition: transform .2s;
    }
    .media-with-text-1:hover {
      transform: scale(1.2); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }
  </style>
@endsection


@section('page_banner')
	<div style="height: 113px;"></div>
    <div class="unit-5 overlay" style='background-image: url("{{ asset('home/images/hero_1.jpg') }}");'>
      	<div class="container text-center">
        	<h1 class="mb-0">Contact Us</h1>
        	<p class="mb-0 unit-6"><a href="/">Home</a> <span class="sep">></span> <span> Contact Us</span></p>
      	</div>
    </div>

    <div class="site-section site-block-feature bg-light">
      <div class="container">
        
        <!-- <div class="text-center mb-5 section-heading">
          <h2>Why Choose Us</h2>
        </div> -->

        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                @endif
            @endforeach
        </div>

        <div class="d-block d-md-flex border-bottom">
          <div class="text-center col-md-3 item border-right" data-aos="fade">
            <span class="flaticon-calculator display-3 mb-3 d-block text-primary"></span>
	            <h2 class="h4">Contact Details</h2>
            <p>+91-8178837584</p>
            <p>phptpoint@gmail.com</p>
          </div>
          <div class="text-center col-md-9 item" data-aos="fade">
            <h2 class="h4 text-center">Send a Message</h2>
            <br>
            <br>
            <form method="post">
            	@csrf
            	<div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile') }}</label>

                    <div class="col-md-6">
                        <input id="number" type="mobile" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}" required pattern="[789][0-9]{9}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Message') }}</label>

                    <div class="col-md-6">
                        <textarea class="form-control" rows="6" required name="message"></textarea>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </form>
          </div>
        </div>
        <!-- <div class="d-block d-md-flex">
          <div class="text-center p-4 item border-right" data-aos="fade">
            <span class="flaticon-stethoscope display-3 mb-3 d-block text-primary"></span>
            <h2 class="h4">Healthcare</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati reprehenderit explicabo quos fugit vitae dolorum.</p>
            <p><a href="#">Read More <span class="icon-arrow-right small"></span></a></p>
          </div>
          <div class="text-center p-4 item" data-aos="fade">
            <span class="flaticon-calculator display-3 mb-3 d-block text-primary"></span>
            <h2 class="h4">Finance &amp; Accounting</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati reprehenderit explicabo quos fugit vitae dolorum.</p>
            <p><a href="#">Read More <span class="icon-arrow-right small"></span></a></p>
          </div>
        </div> -->
      </div>
    </div>

    
    
@endsection