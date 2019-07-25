@extends('layouts.admin')

@section('page_heading')
    Pages
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Pages</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('pages.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Pages</a>
          </div>
        </div>
        <div class="box-body">
            @if(count($pages))
                <table class="table table-responsive ">
                    <tr>
                        <form action="">
                            <th colspan="2">
                                <input type="text" placeholder="Enter Search Keyword" class="form-control" name="search" @if(!empty($_GET['search'])) value="{{ $_GET['search'] }}" @endif>
                            </th>
                            <th colspan="1">
                                <input type="submit" class="btn btn-primary">
                            </th>
                        </form>
                    </tr>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                            if(isset($_GET['page']))
                            {
                                $i  =    $limit*--$_GET['page']+1;   
                            }

                        @endphp

                        @foreach($pages as $pag)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $pag->page_name }}</td>
                                
                                <td>
                                    <a href="{{ route('pages.show', $pag->id) }}" title="View" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('pages.edit', $pag->id) }}" title="Edit" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                                    <button title="Edit" class="btn btn-danger" onclick="deletemodalopen({{ $pag->id }});"><i class="fa fa-trash"></i></button>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                No data found
            @endif
        </div>
        <div class="box-footer">
          {{ $pages->appends($_GET)->links() }}
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
