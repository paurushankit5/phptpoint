@extends('layouts.admin')

@section('page_heading')
    Sub-Tutorial
@endsection
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css') }}" type="text/css" media="screen" />
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Sub-Tutorial</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('subtutorials.edit', $subtutorial->id) }}" title="Edit" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                <button title="Edit" class="btn btn-danger" onclick="deletemodalopen({{ $subtutorial->id }});"><i class="fa fa-trash"></i></button>
          </div>
        </div>
        <div class="box-body">
            <table class="table table-responsive ">
                <tr>
                	<th>Sub-Tutorial Name</th>
                	<td>{{ $subtutorial->subtut_name }}</td>
                </tr>
                <tr>
                	<th>Page Name</th>
                	<td>{{ $subtutorial->page_name }}</td>
                </tr>
                <tr>
                    <th>Downloads</th>
                    <td>{{ $subtutorial->downloads->count() }}</td>
                </tr>
                <tr>
                	<th>Content</th>
                	<td>{!! $subtutorial->content !!}</td>
                </tr>
                <tr>
                	<th>Url</th>
                	<td><a href="{{ env('APP_URL') }}/{{ $subtutorial->slug->slug }}" target="_blank">{{ env('APP_URL') }}/{{ $subtutorial->slug->slug }}</a></td>
                </tr>
                <tr>
                	<th>Category</th>
                	<td> 
                        @php
                            if($subtutorial->tutorial->category)
                            {
                                echo $subtutorial->tutorial->category->cat_name ;
                            }
                        @endphp
                    </td>
                </tr>
                <tr>
                	<th>Tutorial</th>
                	<td> 
                        @php
                            if($subtutorial->tutorial)
                            {
                                echo $subtutorial->tutorial->tut_name ;
                            }
                        @endphp
                    </td>
                </tr>
                <tr>
                	<th>Page Title</th>
                	<td>{{ $subtutorial->page_title }}</td>
                </tr>
                <tr>
                	<th>Meta Title</th>
                	<td>{{ $subtutorial->meta_title }}</td>
                </tr>
                <tr>
                	<th>Meta Keyword</th>
                	<td>{{ $subtutorial->meta_keyword }}</td>
                </tr>
                <tr>
                	<th>Meta Description</th>
                	<td>{{ $subtutorial->meta_description }}</td>
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
                        @if($subtutorial->zip_name)
                            <a href="/getsubtutorialfile/{{ $subtutorial->id }}">{{ $subtutorial->zip_name }}</a>
                        @else 
                        N/A
                        @endif
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-primary" onclick="showplupload();" title="Add/Edit Code"><i class="fa fa-pencil"></i></button>
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

    <script type="text/javascript">
        function deletemodalopen(id){
            $('#deleteform').attr('action', '/phpadmin/subtutorials/'+id);
            $('#deletemodal').modal('toggle');
        }
    </script>
   @endsection

@section('after_scripts')
    <script type="text/javascript" src="{{ asset('plupload/js/plupload.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plupload/js/jquery.plupload.queue/jquery.plupload.queue.js') }}"></script>
    <script type="text/javascript">
            

        // Setup html5 version
        $("#html5_uploader").pluploadQueue({
            // General settings
            runtimes : 'html5',
            url : '/phpadmin/subtutorials/uploadzip/{{ $subtutorial->id }}',
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
