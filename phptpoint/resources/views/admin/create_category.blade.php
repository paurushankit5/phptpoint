@extends('layouts.admin')

@section('page_heading')
    Categories
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Categories</h3>
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
            <form class="form form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('categories.store') }}">
            	@csrf
            	<div class="form form-group">
            		<label>Category Name</label>
            		<input type="text" class="form-control" value="{{ old('category_name') }}" name="category_name" placeholder="Enter Category Name">
            	</div>
                <div class="form form-group">
                    <label>Include In Top Menu</label>
                    <br>
                    <label>  <input type="radio" value="1" checked  name="is_top_menu"> Yes </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>  <input type="radio" value="0"  name="is_top_menu"> No </label>
                </div>
                <div class="form-group">
                    <label>Image*</label>
                    <input type="file" accept="image/*" required name="image" class="form-control">
                </div>
            	<div class="form form-group">
            		<input type="submit" class="btn btn-primary">
               	</div>
            </form>
        	</div>
        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection
