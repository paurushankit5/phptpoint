@extends('layouts.admin')

@section('page_heading')
    Page
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Page</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('pages.edit', $page->id) }}" title="Edit" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                <button title="Edit" class="btn btn-danger" onclick="deletemodalopen({{ $page->id }});"><i class="fa fa-trash"></i></button>
          </div>
        </div>
        <div class="box-body">
            <table class="table table-responsive ">
                
                <tr>
                	<th>Page Name</th>
                	<td>{{ $page->page_name }}</td>
                </tr>
                
                

                <tr>
                	<th>Url</th>
                	<td>
                        @php
                            if($page->external_link==''){
                                @endphp
                                    <a href="{{ env('APP_URL') }}/{{ $page->slug->slug }}" target="_blank">{{ env('APP_URL') }}/{{ $page->slug->slug }}/</a>
                                @php
                            }
                            else{
                                @endphp
                                <a href="{{ $page->external_link }}">{{ $page->external_link }}</a>
                                @php
                            }
                        @endphp
                        
                    </td>
                </tr>
                <tr>
                    <th>Content</th>
                    <td>{!! $page->content !!}</td>
                </tr>
                <tr>
                	<th>Page Title</th>
                	<td>{{ $page->page_title }}</td>
                </tr>
                <tr>
                	<th>Meta Title</th>
                	<td>{{ $page->meta_title }}</td>
                </tr>
                <tr>
                	<th>Meta Keyword</th>
                	<td>{{ $page->meta_keyword }}</td>
                </tr>
                <tr>
                	<th>Meta Description</th>
                	<td>{{ $page->meta_description }}</td>
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
            $('#deleteform').attr('action', '/phpadmin/pages/'+id);
            $('#deletemodal').modal('toggle');
        }
    </script>
   @endsection
