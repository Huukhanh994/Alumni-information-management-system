@extends('layouts.admin')
@section('content')
    <div class="row">
    <form action="{{route('class/create/submit')}}" method="post">
        @csrf
            <h4>Chuyên ngành:</h4>
            <select name="major_branch_id" class="form-control pull-right">
                @foreach($chuyennganh as $cn)
                    <option value="{{$cn->major_branch_id}}">{{$cn->major_branch_name}}</option>
                @endforeach
            </select>
            <h4>Mã lớp:</h4>
            <input type="text"  name="class_code" id="class_code">
            <h4>Tên lớp</h4>
            <input type="text"  name="class_name" id="class_name">
            <h4>Năm bắt đầu</h4>
            <input type="date" class="form-control" id="class_begin" name="class_begin" placeholder="class_begin">
            <h4>Năm kết thúc</h4>
            <input type="date" class="form-control" id="class_end" name="class_end" placeholder="class_end">
            <button class="btn btn-success" type="submit">Submit</button>
            <a href="{{route('class/index')}}" class="btn btn-default">Back</a>
        </form>
        
    </div>

@endsection
@section('script')
    <script>
        
    </script>
@endsection