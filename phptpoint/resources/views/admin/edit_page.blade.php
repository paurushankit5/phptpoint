    @extends('layouts.admin')

@section('header_scripts')
    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<!--     <script type="text/javascript" src="{{ asset('ckeditor/sample.js') }}"></script>
 -->@endsection


@section('page_heading')
    Edit Page
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Page</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('pages.index') }}" class="btn btn-primary"> Page List</a>
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
			{{ Form::open(array('url' => route("pages.update",$page->id), 'method' => 'PUT', 'class'=>'form form-horizontal')) }}            	@csrf
            	
            	
                <div class="form-group">
                    <label>Page Name*</label>
                    <input type="text" class="form-control" name="page_name" id="page_name" value="{{ $page->page_name }}" placeholder="Enter Page Name to displayed as header" required>
                </div>
                <div class="form-group">
                    <label>External Link*</label>
                    <label class="radio-inline">
                      <input type="radio" name="external_link_radio" value="1" @if($page->external_link != '') checked @endif > Yes
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="external_link_radio" value="0"  @if($page->external_link == '') checked @endif> No
                    </label>
                </div>
                <div class="form-group  @if($page->external_link == '') hidden  @endif external_link">
                    <label>Provide External Link</label>
                    <input type="url" class="form-control" name="external_link" value="{{ $page->external_link }}" >
                </div>
                <div class="test_field  @if($page->external_link != '') hidden @endif ">
                    <div class="form-group">
                        <label>Contents*</label>
                        <textarea lass="form-control" name="content" id="editor1" placeholder="Enter Tutorial Name" required>{{ $page->content }}</textarea>
                    </div>
                    <div class="row bg-primary">
                        <h3 class="text text-center">SEO Panel</h3>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" 
                        @php
                        	if($page->slug!='')
                        	{
                        		@endphp
                        			value="{{ $page->slug->slug }}"
                        		@php
                        	}
                        @endphp
                        >
                    </div>
                    <div class="form-group">
                        <label>Page Title</label>
                        <input type="text" class="form-control" name="page_title" value="{{ $page->page_title  }}">
                    </div>
                    <div class="form-group">
                        <label>Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ $page->meta_title  }}">
                    </div>
                    <div class="form-group">
                        <label>Meta Keyword</label>
                        <input type="text" class="form-control" name="meta_keyword" value="{{ $page->meta_keyword  }}">
                    </div>
                    <div class="form-group">
                        <label>Meta Description</label>
                        <input type="text" class="form-control" name="meta_description" value="{{ $page->meta_description  }}">
                    </div>
                    <div class="row bg-primary">
                        <h3 class="text text-center">Sidebars</h3>
                    </div>
                    <div class="form-group">
                        <label>Select Sidebars</label>
                        <select class="form-control" name="sidebars[]" id="sidebars" multiple>
                            @if($sidebars)
                                @foreach($sidebars as $sidebar)
                                    <option value="{{ $sidebar->id }}" @php if(in_array($sidebar->id,$linked_sidebar)){ echo "selected";} @endphp>{{ $sidebar->sidebar_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
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
        $("#page_name").blur(function(){
            var page_name = $("#page_name").val();
            if(page_name!='')
            {
                var slug = convertToSlug(page_name);
                $("#slug").val(slug);
            }
        });
        $('input[type=radio][name=external_link_radio]').change(function() {
            if (this.value == 1) {
                $(".test_field").addClass('hidden');
                $(".external_link").removeClass('hidden');
            }
            else{
               $(".test_field").removeClass('hidden');
                $(".external_link").addClass('hidden');
            }
        });
    </script>

@endsection
