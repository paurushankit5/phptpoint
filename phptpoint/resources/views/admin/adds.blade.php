@extends('layouts.admin')

@section('page_heading')
    Adds
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Adds</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('adds.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Adds</a>
          </div>
        </div>
        <div class="box-body">
            @if(count($adds))
                <table class="table table-responsive ">
                    <thead>
                        <tr>
                            <form action="">
                                <th colspan="2">
                                    <input type="text" placeholder="Enter Search Keyword" class="form-control" name="search" @if(!empty($_GET['search'])) value="{{ $_GET['search'] }}" @endif>
                                </th>
                                <th colspan="2">
                                    <input type="submit" class="btn btn-primary">
                                </th>
                            </form>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
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

                        @foreach($adds as $add)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $add->add_name }}</td>
                                <td>{{ ucwords($add->add_type) }}</td>
                                <td>
                                    <a href="{{ route('adds.edit', $add->id) }}" title="Edit" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                                    <button title="Edit" class="btn btn-danger" onclick="deletemodalopen({{ $add->id }});"><i class="fa fa-trash"></i></button>
                                    
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
          {{ $adds->appends($_GET)->links() }}
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
            $('#deleteform').attr('action', '/phpadmin/adds/'+id);
            $('#deletemodal').modal('toggle');
        }
    </script>
@endsection
