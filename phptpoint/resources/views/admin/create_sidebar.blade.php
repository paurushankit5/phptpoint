@extends('layouts.admin')

@section('page_heading')
    Add Sidebar
@endsection


@section('content')
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
                <form class="form form-horizontal" method="post" action="{{ route('sidebars.store') }}">
                	@csrf
                	<div class="form-group">
                		<label>Sidebar Name</label>
                		<input type="text" class="form-control" required name="sidebar_name" placeholder="Enter Sidebar Name">
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
                        <!-- <div class="col-md-2 text-center">
                            <br>
                            <br>
                            <br>
                            <br>
                            <button type="button" class="btn btn-arrow" onclick="moveDataToDestination();"> <i class="fa fa-arrow-right" aria-hidden="true"></i> </button><br><br>
                            <button type="button" class="btn btn-arrow" onclick="moveDataToSource();"> <i class="fa fa-arrow-left" aria-hidden="true"></i> </button>
                        </div>
                        <div class="col-md-5">
                            <select class="form-control multiple-dropdown" multiple id="multiple_destination"></select>
                        </div> -->
                    </div>
                    <!-- <div class="text-div" style="display:none">
                        <div class="form-group">
                            <label>External Link</label>
                            <input type="url" class="form-control" name="external_link" placeholder="Enter External Link URL">
                        </div>
                        <div class="form-group">
                            <label>Image Link</label>
                            <input type="url" class="form-control" name="external_link_image" placeholder="Enter Image URL">
                        </div>
                    </div> -->
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
        /*function moveDataToDestination(){
            //$("#multiple_destination").html("");
            $("#multiple_source option").each(function(){

                if($(this).prop('selected'))
                {

                    //console.log($(this).html());
                    $("#multiple_destination").append('<option value="'+$(this).val()+'">'+$(this).html()+'</option>');
                    $(this).remove();

                }
            });
        }
        function moveDataToSource(){
            $("#multiple_destination option").each(function(){

                if($(this).prop('selected'))
                {
                    //console.log($(this).html());
                    $("#multiple_source").append('<option value="'+$(this).val()+'">'+$(this).html()+'</option>');
                    $(this).remove();
                }
            });
        }*/
    </script>

    
@endsection
