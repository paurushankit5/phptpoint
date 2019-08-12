@extends('layouts.admin')

@section('page_heading')
    {{ $user->name }}
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $user->name }}</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('users.edit', $user->id) }}" title="Edit" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                <!-- <button title="Edit" class="btn btn-danger" onclick="deletemodalopen({{ $user->id }});"><i class="fa fa-trash"></i></button> -->
          </div>
        </div>
        <div class="box-body">
            <table class="table table-responsive @if($user->status == 0) bg-danger @endif ">
                <tr>
                	<th> Name</th>
                	<td>{{ $user->name }}</td>
                </tr>
                <tr>
                	<th>Email</th>
                	<td>{{ $user->email }}</td>
                </tr>
                
                <tr>
                	<th>Mobile</th>
                	<td>{!! $user->mobile !!}</td>
                </tr>
                
                <tr>
                	<th>Type</th>
                	<td> 
                        @if($user->is_admin == 1)
                            Admin
                        @elseif($user->is_author == 1)
                            Author
                        @elseif($user->is_student == 1)
                            Student
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @php
                            if($user->status == 1)
                            {
                                echo "Active";
                            }
                            else{
                                echo "Inactive";
                            }
                        @endphp
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
        // function deletemodalopen(id){
        //     $('#deleteform').attr('action', '/phpadmin/users/'+id);
        //     $('#deletemodal').modal('toggle');
        // }
    </script>
   @endsection
