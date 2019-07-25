@extends('layouts.admin')

@section('page_heading')
    Tutorials
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tutorials</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('tutorials.edit', $tutorial->id) }}" title="Edit" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                <button title="Edit" class="btn btn-danger" onclick="deletemodalopen({{ $tutorial->id }});"><i class="fa fa-trash"></i></button>
          </div>
        </div>
        <div class="box-body">
            <table class="table table-responsive ">
                <tr>
                	<th>Tutorial Name</th>
                	<td>{{ $tutorial->tut_name }}</td>
                </tr>
                <tr>
                	<th>Page Name</th>
                	<td>{{ $tutorial->page_name }}</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($tutorial->image)
                            <img src="{{asset('images/'.$tutorial->image)}}" class="img img-responsive" style="width: 200px;">
                        @endif
                    </td>
                </tr>
                <tr>
                	<th>Content</th>
                	<td>{!! $tutorial->content !!}</td>
                </tr>
                <tr>
                	<th>Url</th>
                	<td><a href="{{ env('APP_URL') }}/{{ $tutorial->slug->slug }}" target="_blank">{{ env('APP_URL') }}/{{ $tutorial->slug->slug }}</a></td>
                </tr>
                <tr>
                	<th>Category</th>
                	<td> 
                        @php
                            if($tutorial->category)
                            {
                                echo $tutorial->category->cat_name ;
                            }
                        @endphp
                    </td>
                </tr>
                <tr>
                	<th>Page Title</th>
                	<td>{{ $tutorial->page_title }}</td>
                </tr>
                <tr>
                	<th>Meta Title</th>
                	<td>{{ $tutorial->meta_title }}</td>
                </tr>
                <tr>
                	<th>Meta Keyword</th>
                	<td>{{ $tutorial->meta_keyword }}</td>
                </tr>
                <tr>
                	<th>Meta Description</th>
                	<td>{{ $tutorial->meta_description }}</td>
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
                @php
                    if(count($tutorial->subtutorial))
                    {
                        @endphp
                            <tr>
                                <th colspan="2">
                                    <div class="col-md-12 bg-primary">
                                        <h3 class="text text-center">Subtutorial List</h3>
                                    </div>
                                </th>
                            </tr>
                        <tr><td colspan='2'>
                            <div class="col-md-12">
                            <a href="{{ route('arrangesubtutorials',$tutorial->id) }}" class="btn btn-primary pull-right"><i class="fa fa-icon-move"></i> Arrange Sub-Tutorial Order</a>
                            <ol>
                        @php
                        foreach($tutorial->subtutorial as $subtut)
                        {
                            @endphp
                                <li><a href="{{ route('subtutorials.show',$subtut->id) }}">{{ $subtut->subtut_name }}</a></li>
                            @php
                        }
                        echo "</ol>";
                    @endphp
                        </div>
                        </td></tr>
                @php
                    }
                @endphp
                

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
            $('#deleteform').attr('action', '/phpadmin/tutorials/'+id);
            $('#deletemodal').modal('toggle');
        }
    </script>
   @endsection
