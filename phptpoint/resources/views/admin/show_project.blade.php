@extends('layouts.admin')

@section('page_heading')
    Project
@endsection

@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css') }}" type="text/css" media="screen" />
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Project</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('projects.edit', $project->id) }}" title="Edit" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                <button title="Edit" class="btn btn-danger" onclick="deletemodalopen({{ $project->id }});"><i class="fa fa-trash"></i></button>
          </div>
        </div>
        <div class="box-body">
            <table class="table table-responsive ">
                <tr>
                	<th>Project Name</th>
                	<td>{{ $project->pro_name }}</td>
                </tr>
                <tr>
                	<th>Page Name</th>
                	<td>{{ $project->page_name }}</td>
                </tr>
                <tr>
                    <th>Top Menu</th>
                    <td>{{ $project->is_top_menu ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <th>Downloads</th>
                    <td>{{ $project->downloads->count() }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>
                        @php
                            if($project->is_paid ==1)
                            {
                                echo "&#x20B9; ".$project->price;
                            }
                            else{
                                echo "Free";
                            }
                        @endphp
                    </td>
                </tr>
                <tr>
                	<th>Content</th>
                	<td>{!! $project->content !!}</td>
                </tr>

                <tr>
                	<th>Video</th>
                	<td>
                		@if($project->video_url)
                			<iframe  src="<?= $project->video_url; ?>" frameborder="0" allowfullscreen></iframe>
                		@else
                			N/A
                		@endif
                	</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($project->pro_image)
                            <img  src="{{ asset('images/projects/'.$project->pro_image) }}"  style="width:200px;">
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                	<th>Url</th>
                	<td><a href="{{ env('APP_URL') }}/projects/{{ $project->slug->slug }}" target="_blank">{{ env('APP_URL') }}/projects/{{ $project->slug->slug }}</a></td>
                </tr>
                <tr>
                	<th>Page Title</th>
                	<td>{{ $project->page_title }}</td>
                </tr>
                <tr>
                	<th>Meta Title</th>
                	<td>{{ $project->meta_title }}</td>
                </tr>
                <tr>
                	<th>Meta Keyword</th>
                	<td>{{ $project->meta_keyword }}</td>
                </tr>
                <tr>
                	<th>Meta Description</th>
                	<td>{{ $project->meta_description }}</td>
                </tr>
                <tr>
                    <th>Sidebars</th>
                    <td>
                        @if(count($sidebars))
                            @foreach($sidebars as $sidebar)
                                <a href="{{ route('sidebars.show', $sidebar->sidebar_id) }}" target="_blank">{{ $sidebar->sidebar->sidebar_name }}</a><br>
                            @endforeach
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>File</th>
                    <td>
                        @if($project->zip_name)
                            <a href="/getprojectfile/{{ $project->slug->slug }}/{{ $project->id }}">{{ $project->zip_name }}</a>
                        @else 
                        N/A
                        @endif
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-primary" onclick="showplupload();" title="Add/Edit Project Code"><i class="fa fa-pencil"></i></button>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <div id="html5_uploader" style="display: none;">Your browser doesn't support native upload.</div>
                    </td>
                </tr>
                

            </table>
          
        </div>
        <div class="box-footer">
        </div>
    </div>
    <!--------------------------delete modal--------------------->
    <div id="deletemodal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Are you sure?</h4>
          </div>
          <div class="modal-body">
            <p>You want to delete this?</p>
            {{ Form::open(array('id'=>'deleteform', 'method' => 'DELETE')) }}
                @csrf
                <button class="btn btn-danger pull-right" type="submit">Yes</button>
            {{ Form::close() }}
            <div class="clearfix"></div>
          </div>
        </div>

      </div>
    </div>
     <!--------------------------delete modal--------------------->
@endsection

@section('after_scripts')
    <script type="text/javascript" src="{{ asset('plupload/js/plupload.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plupload/js/jquery.plupload.queue/jquery.plupload.queue.js') }}"></script>
    <script type="text/javascript">
        function deletemodalopen(id){
            $('#deleteform').attr('action', '/phpadmin/projects/'+id);
            $('#deletemodal').modal('toggle');
        }
    

    // Setup html5 version
    $("#html5_uploader").pluploadQueue({
        // General settings
        runtimes : 'html5',
        url : '/phpadmin/projects/uploadzip/{{ $project->id }}',
        chunk_size : '1mb',
        unique_names : true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        filters : {
            max_file_size : '1000mb',
            mime_types: [
                /*{title : "Image files", extensions : "jpg,gif,png"},*/
                {title : "Zip files", extensions : "zip"},
                {title : "Rar files", extensions : "rar"}
            ]
        },

        // Resize images on clientside if we can
        resize : {width : 320, height : 100, quality : 90}
    });

    function showplupload(){
        $("#html5_uploader").slideToggle();
    }
  
</script>
   @endsection


