@extends('layouts.admin')

@section('page_heading')
    Edit SEO
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit SEO</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('seo.index') }}" class="btn btn-primary"> SEO List</a>
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
            {{ Form::open(array('url' => route("seo.update",$seo->id), 'method' => 'PUT', 'class'=>'form form-horizontal')) }}
            	@csrf
            	@csrf
            	<div class="form form-group">
            		<label>Page Name</label>
            		<input type="text" class="form-control" value="{{ $seo->page_name }}" name="page_name"required placeholder="Enter Page Name">
            	</div>
            	 <div class="form-group">
                    <label>Page Title</label>
                    <input type="text" class="form-control" name="page_title" value="{{ $seo->page_title  }}">
                </div>
                <div class="form-group">
                    <label>Meta Title</label>
                    <input type="text" class="form-control" name="meta_title" value="{{ $seo->meta_title  }}">
                </div>
                <div class="form-group">
                    <label>Meta Keyword</label>
                    <input type="text" class="form-control" name="meta_keyword" value="{{ $seo->meta_keyword  }}">
                </div>
                <div class="form-group">
                    <label>Meta Description</label>
                    <input type="text" class="form-control" name="meta_description" value="{{ $seo->meta_description  }}">
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
