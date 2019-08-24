@extends('layouts.admin')

@section('header_scripts')
    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<!--     <script type="text/javascript" src="{{ asset('ckeditor/sample.js') }}"></script>
 -->@endsection


@section('page_heading')
    Add Project
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add Project</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('projects.index') }}" class="btn btn-primary"> Project List</a>
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
            <form class="form form-horizontal" id="submitForm" method="post" enctype="multipart/form-data" action="{{ route('projects.store') }}">
            	@csrf
            	
            	<div class="form-group">
            		<label>Project Name*</label>
            		<input type="text" class="form-control" name="project_name" id="project_name" value="{{ old('project_name') }}" placeholder="Enter Project Name to be displayed on menu bar" required>
            	</div>
                <div class="form-group">
                    <label>Page Name*</label>
                    <input type="text" class="form-control" name="page_name" id="page_name" value="{{ old('page_name') }}" placeholder="Enter Page Name to displayed as header" required>
                </div>
                <div class="form-group">
                    <label>Paid*</label>
                    <label class="radio-inline">
                      <input type="radio" name="is_paid" value="1" checked> Yes
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_paid" value="0"> No
                    </label>
                </div>
                <div class="form-group price_field">
                    <label>Price</label>
                    <input type="text" class="form-control" name="project_price" id="project_price" value="{{ old('project_price') }}" placeholder="Enter Project Price in INR" >
                </div>
                <div class="form-group">
                    <label>Youtube Embed Link</label>
                    <input type="url" class="form-control" name="youtube_embed_link" id="youtube_embed_link" value="{{ old('youtube_embed_link') }}" placeholder="Enter youtube embed link" >
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" accept="image/*" class="form-control" name="pro_image" id="pro_image">
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
        $("#project_name").blur(function(){
            var project_name = $("#project_name").val();
            if(project_name!='')
            {
                var slug = convertToSlug(project_name);
                $("#slug").val(slug);
            }
        });
        $('input[type=radio][name=is_paid]').change(function() {
		    if (this.value == 1) {
		        $(".price_field").show();
		    }
		    else{
		       $(".price_field").hide();
		       $("#project_price").val(0);
		    }
		});
    </script>

@endsection
