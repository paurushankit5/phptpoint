@extends('layouts.admin')

@section('page_heading')
    Sub-Tutorials
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Sub-Tutorials</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('subtutorials.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Sub-Tutorials</a>
          </div>
        </div>
        <div class="box-body">
            @if(count($subtutorials))
                <table class="table table-responsive ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Tutorial</th>
                            <th>Status</th>
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

                        @foreach($subtutorials as $subtut)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $subtut->subtut_name }}</td>
                                <td><a href="/phpadmin/tutorials/{{$subtut->tutorial->id}}">{{ $subtut->tutorial->tut_name }}</a></td>
                                <td>
                                    @php
                                        if($subtut->status == 1)
                                        {
                                            echo "Active";
                                        }
                                        else{
                                            echo "Inactive";
                                        }
                                    @endphp
                                </td>
                                <td>
                                    <a href="{{ route('subtutorials.show', $subtut->id) }}" title="View" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('subtutorials.edit', $subtut->id) }}" title="Edit" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                                    <button title="Edit" class="btn btn-danger" onclick="deletemodalopen({{ $subtut->id }});"><i class="fa fa-trash"></i></button>
                                    
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
          {{ $subtutorials->links() }}
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
