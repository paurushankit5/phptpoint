@extends('layouts.admin')

@section('page_heading')
    Categories
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Category</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('categories.index') }}" class="btn btn-primary"> Category List</a>
          </div>
        </div>
        <div class="box-body">
            <div class="col-md-12">
            	@if ($errors->any())
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
				{{ Form::open(array('url' => route("categories.update",$category->id), 'method' => 'PUT', 'class'=>'form form-horizontal', 'files' => true)) }}
	            	@csrf
	            	<div class="form form-group">
	            		<label>Category Name</label>
	            		<input type="text" class="form-control" name="category_name" value="{{ $category->cat_name}}" placeholder="Enter Category Name">
	            	</div>
	            	<div class="form-group">
	                    <label>Image*</label>
	                    <input type="file" accept="image/*" name="image" class="form-control">
	                </div>
	            	<div class="form form-group">
	            		<input type="submit" class="btn btn-primary">
	               	</div>
	            {{ Form::close() }}
	            @if($category->image)
	            	<img src="{{ asset('images/'.$category->image) }}" class="img img-responsive" style="width:200px;">
	            @endif
        	</div>
        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection
