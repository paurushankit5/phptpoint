@extends('layouts.admin')

@section('page_heading')
    Sidebars
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Sidebars</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('sidebars.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Sidebars</a>
          </div>
        </div>
        <div class="box-body">
            @if(count($sidebars))
                <table class="table table-responsive ">
                    <thead>
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

                        @foreach($sidebars as $sidebar)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $sidebar->sidebar_name }}</td>
                                <td>{{ $sidebar->sidebar_type }}</td>
                                <td>
                                    <a href="{{ route('sidebars.edit', $sidebar->id) }}" title="Edit" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                                    <button title="Edit" class="btn btn-danger" onclick="deletemodalopen({{ $sidebar->id }});"><i class="fa fa-trash"></i></button>
                                    
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
          {{ $sidebars->links() }}
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
	<script type="text/javascript">
        function deletemodalopen(id){
            $('#deleteform').attr('action', '/phpadmin/sidebars/'+id);
            $('#deletemodal').modal('toggle');
        }
    </script>

    
@endsection
