@extends('layouts.admin')
@section('content')
    <div class="row">
    <form action="{{route('khoa-vien/them/submit')}}" method="post">
        @csrf
            <h4>Mã khoa</h4>
            <input type="text" name="academy_code" id="academy_code">
            <h4>Tên khoa</h4>
            <input type="text" name="academy_name" id="academy_name" />
            <h4>Mô tả khoa</h4>
            <input type="text"  name="academy_description" id="academy_description">
            <button class="btn btn-success" type="submit">Submit</button>
            <a href="{{route('khoa-vien/index')}}" class="btn btn-default">Back</a>
        </form>
        
    </div>

@endsection
@section('script')
    <script>
        
    </script>
@endsection