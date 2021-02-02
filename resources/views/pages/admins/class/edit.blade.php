@extends('layouts.admin')

@section('content')
<div class="row">
    @if($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
        <p>{{$message}}</p>
        <p class="mb-0"></p>
        </div>
    @endif
    <form action="{{action('Master\ClassController@update',$class_id)}}" method="POST">
        @csrf
        <fieldset class="form-group row">
            <label for="major_branch_code" class="col-sm-1-12 col-form-label">Chuyên ngành:</label>
            <select name="major_branch_id" class="form-control pull-right">
                @foreach($chuyennganh as $cn)
                <option value="{{$cn->major_branch_id}}" @if($cn->major_branch_id == $class->major_branch_id) selected @endif>{{$cn->major_branch_name}}</option>
                @endforeach
            </select>
        </fieldset>
        <fieldset class="form-group row">
            <label for="class_code" class="col-sm-1-12 col-form-label">Mã lớp:</label>
            <input type="text" class="form-control" name="class_code" id="class_code" placeholder="" value="{{$class->class_code}}">
        </fieldset>
        <fieldset class="form-group row">
            <label for="class_code" class="col-sm-1-12 col-form-label">Tên lớp:</label>
            <input type="text" class="form-control" name="class_name" id="class_name" placeholder="" value="{{$class->class_name}}">
        </fieldset>
        <fieldset class="form-group row">
            <label for="class_code" class="col-sm-1-12 col-form-label">Năm bắt đầu:</label>
            <input type="date" class="form-control" name="class_begin" id="class_begin" placeholder="" value="{{$class->class_begin}}">
        </fieldset>
        <fieldset class="form-group row">
            <label for="class_code" class="col-sm-1-12 col-form-label">Năm kết thúc:</label>
            <input type="date" class="form-control" name="class_end" id="class_end" placeholder="" value="{{$class->class_end}}">
        </fieldset>
        
        <div class="form-group">
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{route('class/index')}}" class="btn btn-default">Back</a>
        </div>
    </form>
</div>
@endsection