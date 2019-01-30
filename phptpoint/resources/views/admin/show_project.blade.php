@extends('layouts.admin')

@section('page_heading')
    Project
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
                	<th>Url</th>
                	<td><a href="{{ env('APP_URL') }}/projects/{{ $project->slug->slug }}" target="_blank">{{ env('APP_URL') }}/projects/{{ $project->slug->slug }}/</a></td>
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

    <script type="text/javascript">
        function deletemodalopen(id){
            $('#deleteform').attr('action', '/phpadmin/projects/'+id);
            $('#deletemodal').modal('toggle');
        }
    </script>
   @endsection
