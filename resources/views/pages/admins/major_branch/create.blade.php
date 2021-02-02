@extends('layouts.admin')
@section('content')
    <div class="row">
    <form action="{{route('major_branch/create/submit')}}" method="post">
        @csrf
            <h4>Mã ngành</h4>
            <select name="major_id"  class="form-control pull-right">
                @foreach($nganh as $n)
                    <option value="{{$n->major_id}}">{{$n->major_name}}</option>
                @endforeach
            </select>
            <h4>Tên chuyên ngành</h4>
            <input type="text"  name="major_branch_name" id="major_branch_name">
            <button class="btn btn-success" type="submit">Submit</button>
            <a href="{{route('major_branch/index')}}" class="btn btn-default">Back</a>
        </form>
        
    </div>

@endsection
@section('script')
    <script>
        
    </script>
@endsection