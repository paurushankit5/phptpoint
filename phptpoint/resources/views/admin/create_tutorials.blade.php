@extends('layouts.admin')

@section('header_scripts')
    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<!--     <script type="text/javascript" src="{{ asset('ckeditor/sample.js') }}"></script>
 -->@endsection


@section('page_heading')
    Add Tutorial
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add Tutorial</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('tutorials.index') }}" class="btn btn-primary"> Tutorial List</a>
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
            <form class="form form-horizontal" id="submitForm" method="post" action="{{ route('tutorials.store') }}" enctype="multipart/form-data">
            	@csrf
            	<div class="form form-group">
            		<label>Category Name</label>
            		<select class="form-control" required name="category_id">
            			<option value="">Select Category</option>
            			@php
            				if(count($categories))
            				{
            					foreach($categories as $cat)
            					{
            						@endphp
            							<option value="{{ $cat->id }}" 
                                            @php 
                                                if($cat->id == old('category_id'))
                                                {
                                                    echo " selected ";
                                                }
                                            @endphp
                                        >
                                            {{ $cat->cat_name }}
                                        </option>
            						@php
            					}
            				}
            			@endphp
            		</select>
            	</div>
            	<div class="form-group">
            		<label>Tutorial Name*</label>
            		<input type="text" class="form-control" name="tutorial_name" id="tutorial_name" value="{{ old('tutorial_name') }}" placeholder="Enter Tutorial Name to be displayed on menu bar" required>
            	</div>
                <div class="form-group">
                    <label>Page Name*</label>
                    <input type="text" class="form-control" name="page_name" id="page_name" value="{{ old('page_name') }}" placeholder="Enter Page Name to displayed as header" required>
                </div>
                <div class="form-group">
                    <label>Image*</label>
                    <input type="file" accept="image/*" required name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label>Publish*</label>
                    <label class="radio-inline">
                      <input type="radio" name="status" checked="" value="1" checked> Yes
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="status" value="0"> No
                    </label>
                </div>

                <div class="form-group">
                    <label>Contents*</label>
                    <textarea lass="form-control" name="content" id="editor1" placeholder="Enter Tutorial Name" required>{{ old('content') }}</textarea>
                </div>
                <div class="row bg-primary">
                    <h3 class="text text-center">SEO Panel</h3>
                </div>
                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug')  }}">
                </div>
                <div class="form-group">
                    <label>Page Title</label>
                    <input type="text" class="form-control" name="page_title" value="{{ old('page_title')  }}">
                </div>
                <div class="form-group">
                    <label>Meta Title</label>
                    <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title')  }}">
                </div>
                <div class="form-group">
                    <label>Meta Keyword</label>
                    <input type="text" class="form-control" name="meta_keyword" value="{{ old('meta_keyword')  }}">
                </div>
                <div class="form-group">
                    <label>Meta Description</label>
                    <input type="text" class="form-control" name="meta_description" value="{{ old('meta_description')  }}">
                </div>
                <div class="row bg-primary">
                    <h3 class="text text-center">Sidebars</h3>
                </div>
                <div class="form-group">
                    <label>Select Sidebars</label>
                    <select class="form-control" name="sidebars[]" id="sidebars" multiple>
                        @if($sidebars)
                            @foreach($sidebars as $sidebar)
                                <option value="{{ $sidebar->id }}">{{ $sidebar->sidebar_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            	<div class="form form-group">
            		<input type="submit" id="formsubmitbtn" class="btn btn-primary">
               	</div>
            </form>
        	</div>
        </div>
        <div class="box-footer">
        </div>
    </div>
    <script>
        CKEDITOR.replace( 'editor1', {
            filebrowserBrowseUrl: "{{ asset('/ckfinder/ckfinder.html') }}",
            filebrowserImageBrowseUrl: "{{ asset('./ckfinder/ckfinder.html?type=Images') }}",
            filebrowserFlashBrowseUrl: "{{ asset('./ckfinder/ckfinder.html?type=Flash') }}",
            filebrowserUploadUrl: "{{ asset('./ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}",
            filebrowserImageUploadUrl: "{{ asset('./ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}",
            filebrowserFlashUploadUrl: "{{ asset('./ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}"
        } );
        
    </script>
@endsection

@section('after_scripts')
    <script type="text/javascript">
        //var formSubmitted = false;
        $("#formsubmitbtn").click( function(event) {
            var data = CKEDITOR.instances.editor1.getData();
            console.log(data);
            //$("#submitForm").submit();
        });
        $("#testbtn").click(function(){
            var str = $("#editor1").val();
            var str1 = $("#editor1").html();
            console.log(str);
            console.log(str1);
        });
        $("#tutorial_name").blur(function(){
            var tutorial_name = $("#tutorial_name").val();
            if(tutorial_name!='')
            {
                var slug = convertToSlug(tutorial_name);
                $("#slug").val(slug);
            }
        });
    </script>

@endsection
