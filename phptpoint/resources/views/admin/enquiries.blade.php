@extends('layouts.admin')

@section('page_heading')
    Enquiry
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Enquiry</h3>
            <div class="box-tools pull-right">
                
          </div>
        </div>
        <div class="box-body">
            @if(count($enquiries))
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
                            <th>Leads</th>
                            <th>Message</th>
                            <th>Delete</th>
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

                        @foreach($enquiries as $enquiry)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                	{{ $enquiry->name }}<br>
                                	{{ $enquiry->email }}<br>
                                	{{ $enquiry->mobile }}<br>
                                	Date - {{ date('d-m-y H:i',strtotime($enquiry->created_at)) }}

                                </td>
                                <td>
                                    {{ $enquiry->message }}
                                </td>
                                <td>
                                    
                                    <button title="Edit" class="btn btn-danger" onclick="deletemodalopen({{ $enquiry->id }});"><i class="fa fa-trash"></i></button>
                                    
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
          {{ $enquiries->appends($_GET)->links() }}
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
            $('#deleteform').attr('action', '/phpadmin/enquiry/'+id);
            $('#deletemodal').modal('toggle');
        }
    </script>
@endsection
