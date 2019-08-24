@extends('layouts.admin')

@section('header_scripts')
    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<!--     <script type="text/javascript" src="{{ asset('ckeditor/sample.js') }}"></script>
 -->@endsection


@section('page_heading')
    Add Advertisement
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add Advertisement</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('adds.index') }}" class="btn btn-primary"> Add List</a>
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
                    {{ Form::open(array('url' => route("adds.update",$add->id), 'method' => 'PUT', 'class'=>'form form-horizontal', 'files' => true)) }}            	
                    @csrf
            	
            	
                <div class="form-group">
                    <label>Add Title*</label>
                    <input type="text" class="form-control" name="add_name" id="add_name" value="{{ $add->add_name }}" placeholder="Enter Add Name" required>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" name="add_type">
                        <option @if($add->add_type == 'right') selected @endif value="right">Right Sidebar</option>
                        <option @if($add->add_type == 'top') selected @endif value="top">Top</option>
                        <option @if($add->add_type == 'bottom') selected @endif value="bottom">Bottom</option>
                    </select>
                </div>
                <div class="test_field">
                    <div class="form-group">
                        <label>Contents*</label>
                        <textarea class="form-control" rows="6" name="content" id="editor1" required>{{ $add->content }}</textarea>
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
        // CKEDITOR.replace( 'editor1', {
        //     filebrowserBrowseUrl: "{{ asset('/ckfinder/ckfinder.html') }}",
        //     filebrowserImageBrowseUrl: "{{ asset('./ckfinder/ckfinder.html?type=Images') }}",
        //     filebrowserFlashBrowseUrl: "{{ asset('./ckfinder/ckfinder.html?type=Flash') }}",
        //     filebrowserUploadUrl: "{{ asset('./ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}",
        //     filebrowserImageUploadUrl: "{{ asset('./ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}",
        //     filebrowserFlashUploadUrl: "{{ asset('./ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}"
        // } );
        
    </script>
@endsection

@section('after_scripts')
    <script type="text/javascript">
        //var formSubmitted = false;
        $("#formsubmitbtn").click( function(event) {
            var data = CKEDITOR.instances.editor1.getData();
            //$("#submitForm").submit();
        });
        $("#testbtn").click(function(){
            // var str = $("#editor1").val();
            // var str1 = $("#editor1").html();
        });
        $("#page_name").blur(function(){
            var page_name = $("#page_name").val();
            if(page_name!='')
            {
                var slug = convertToSlug(page_name);
                $("#slug").val(slug);
            }
        });
        
    </script>

@endsection
