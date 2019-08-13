@extends('layouts.admin')

@section('page_heading')
    Edit {{ $user->name }}
@endsection


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit {{ $user->name }}</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('users.index') }}" class="btn btn-primary"> User List</a>
          </div>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            {{ Form::open(array('url' => route("users.update",$user->id), 'method' => 'PUT', 'class'=>'form form-horizontal')) }}
                @csrf
                @csrf
                <div class="form form-group">
                    <label>Name</label>
                    <input type="text"  class="form-control" value="{{ $user->name }}" name="name"required placeholder="Enter Page Name">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" required class="form-control" name="email" value="{{ $user->email  }}">
                </div>
                <div class="form-group">
                    <label>Mobile</label>
                    <input type="number" class="form-control" name="mobile" value="{{ $user->mobile  }}">
                </div>
                <div class="form-group">
                    <label>User Type</label>
                    <select class="form-control" name="user_type">
                        <option value="student" @if($user->is_student) checked @endif >Student</option>
                        <option value="author"  @if($user->is_author) checked @endif >Author</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>User Status</label>
                    <select class="form-control" name="status">
                        <option value="1" @if($user->status == 1) checked @endif >Active</option>
                        <option value="0"  @if($user->status == 0) checked @endif >Deactivate</option>
                    </select>
                </div>
                <div class="form form-group">
                    <input type="submit" class="btn btn-primary">
                </div>
                
            </form>
            </div>
        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection
