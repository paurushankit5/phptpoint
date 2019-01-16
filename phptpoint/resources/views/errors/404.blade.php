@extends('layouts.main')

@section('title')
	Error 404 : Page Not Found
@endsection

@section('content')
	<div style="height: 113px;"></div>

	<div class="row">
   		<div class="col-lg-12">
            <div class="p-12 mb-12 bg-white">
            	<h1 class="text text-bold text-center text-danger error-page-heading">404</h1>
            	<h3 class="text text-center error-page-para">PAGE NOT FOUND.</h3>
            	<div class="col-md-12 text-center">
            		<a href="/" class="btn btn-primary no-border-radius btn-lg">Go To Home</a>
            		<br>
            		<br>
            		<br>
            		<br>
            	</div>
            </div>
        </div>
    </div>
@endsection