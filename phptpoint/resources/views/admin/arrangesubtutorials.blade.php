@extends('layouts.admin')

@section('page_heading')
    Arrange Sub-Tutorial
@endsection


@section('content')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 1em; padding-left: 1.5em; font-size: 1.4em; height: auto; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    
    $j = jQuery.noConflict();
    $j( function() {
        $j( "#sortable" ).sortable();
        $j( "#sortable" ).disableSelection();
    });
    function sortnow(){
        var sortedIDs = $j( "#sortable" ).sortable( "toArray" );
        $j.ajax({
            type: 'POST',
            data : {"ids"   :  sortedIDs, "_token": "{{ csrf_token() }}", },
            url : '/phpadmin/arrangesubtutorials',
            success :   function(data){
               location.reload();
            }
        })
    }
  
  </script>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Arrange Sub-Tutorial</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('tutorials.show',$tut->id) }}" class="btn btn-primary">{{ $tut->tut_name }}</a>
          </div>
        </div>
        <div class="box-body">
                @if(count($tut->subtutorial))
                    <ul id="sortable">
                        @foreach($tut->subtutorial as $subtut)
                            <li class="ui-state-default" id="{{ $subtut->id }}"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{ $subtut->subtut_name }} </li>
                        @endforeach
                    </ul>
                    <br>
                    <button id="sort" onclick="sortnow();" class="btn btn-primary">Save</button>
                @endif
        </div>
        <div class="box-footer">
        </div>
    </div>
    

@endsection
