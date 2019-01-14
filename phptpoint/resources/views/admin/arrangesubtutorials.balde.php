@extends('layouts.admin')

@section('page_heading')
    Arrange Sub-Tutorial
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Arrange Sub-Tutorial</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('tutorial.show',$tutorial->id) }}" class="btn btn-primary">{{ $tutorial->tut_name }}</a>
          </div>
        </div>
        <div class="box-body">
           
        </div>
        <div class="box-footer">
        </div>
    </div>
    

@endsection
