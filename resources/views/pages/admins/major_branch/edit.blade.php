@extends('layouts.admin')

@section('content')
<div class="row">
    @if($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
        <p>{{$message}}</p>
        <p class="mb-0"></p>
        </div>
    @endif
    <form action="{{action('Master\MajorBranchController@update',$major_branch_id)}}" method="POST">
        @csrf
        <fieldset class="form-group row">
            <label for="major_code" class="col-sm-1-12 col-form-label">Mã ngành:</label>
            <select name="major_id" class="form-control pull-right">
                @foreach($nganh as $n)
                <option value="{{$n->major_id}}" @if($n->major_id == $major_branch->major_id) selected @endif>{{$n->major_name}}</option>
                @endforeach
            </select>
        </fieldset>
        <fieldset class="form-group row">
            <label for="major_branch_name" class="col-sm-1-12 col-form-label">Tên chuyên ngành:</label>
                <input type="text" class="form-control" name="major_branch_name" id="major_branch_name" placeholder="" value="{{$major_branch->major_branch_name}}">
        </fieldset>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{route('major_branch/index')}}" class="btn btn-default">Back</a>
        </div>
    </form>
</div>
@endsection