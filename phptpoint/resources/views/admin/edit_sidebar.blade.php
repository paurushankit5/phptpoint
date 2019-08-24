@extends('layouts.admin')

@section('page_heading')
    Add Sidebar
@endsection


@section('content')
	<?php
    	$ids = '';
		if($count = count($sidebar->sidebar_content))
		{
			$ids = '[';
			$i=1;
			foreach ($sidebar->sidebar_content as $content) {
				$ids  .=  "'".$content->destination_id."'";
				if($i!= $count){
					$ids  .= ",";
				}
				$i++;
			}
			$ids .= ']';
		}

	?>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add Sidebar</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('sidebars.index') }}" class="btn btn-primary"> Sidebars List</a>
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
                {{ Form::open(array('url' => route("sidebars.update",$sidebar->id), 'method' => 'PUT', 'class'=>'form form-horizontal')) }}

                	@csrf
                	<div class="form-group">
                		<label>Sidebar Name</label>
                		<input type="text" class="form-control" required name="sidebar_name" value="{{ $sidebar->sidebar_name }}" placeholder="Enter Sidebar Name">
                	</div>
                    <div class="form-group">
                        <label>Sidebar Type</label>
                        <select class="form-control" required name="sidebar_type" id="sidebar_type">
                            <option value="">Select Sidebar Type</option>
                            <option value="tutorial">Tutorials</option>
                            <option value="sub_tutorial">Sub-Tutorials</option>
                            <option value="free_project">Free Project</option>
                            <option value="paid_project">Paid Project</option>
                            <option value="page">Pages</option>
                        </select>
                    </div>
                    <div class="form-group multiple-dropdown-div" style="display: none;">
                        <label>Select Topics</label>
                        <select class="form-control multiple-dropdown" multiple name="topics[]" id="multiple_source" required></select>                  
                    </div>
                	<div class="form-group">
                		<input type="submit" id="submit-btn" class="btn btn-primary">
                   	</div>
                </form>
        	</div>
        </div>
        <div class="box-footer">
        </div>
    </div>
    
@endsection


@section('after_scripts')
    <script type="text/javascript">
        $("#sidebar_type").change(function(){
            var data = this.value;
            if(data == 'tutorial' || data == "free_project" || data == "sub_tutorial" || data == "paid_project" || data == "page")
            {
                $("#submit-btn").hide();
                $(".multiple-dropdown-div").show();
                $("#multiple_source").html("");
                $.ajax({
                    type : "GET",
                    url  : "/ajax/getalllistfromtable",
                    data : {
                        "table" : data,
                    },
                    success : function(data)
                    {
                        //console.log(data);
                        data = JSON.parse(data);
                        var count = data.length;
                        
                        if(count>0)
                        { 
                            $("#submit-btn").show();
                            $(data).each(function(){
                                $("#multiple_source").append('<option value="'+this.id+'">'+this.name+'</option>');
                            });
                            //$("#multiple_destination").html("");
                        }
                        else{
                            $("#submit-btn").hide();
                        }
                    }
                });
            }
            else{
                $(".multiple-dropdown-div").hide();
                $("#submit-btn").hide();
            }
        });
        $(document).ready(function(){
        	$("#sidebar_type").val("<?= $sidebar->sidebar_type; ?>");
        	$("#sidebar_type").trigger("change");
        	
        	setTimeout(function(){
        		$("#multiple_source").val(<?= $ids; ?>);
        	},500);
        });
    </script>


    
@endsection
