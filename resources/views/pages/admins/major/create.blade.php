@extends('layouts.admin')
@section('content')
    <div class="row">
    <form action="{{route('major/create/submit')}}" method="post">
        @csrf
            <h4>Mã khoa</h4>
                <select name="academy_id"  class="form-control pull-right">
                    @foreach($khoa as $k)
                        <option value="{{$k->academy_id}}">{{$k->academy_name}}</option>
                    @endforeach
                </select>
            <h4>Mã ngành</h4>
            <input type="text" name="major_code" id="major_code">
            <h4>Tên ngành</h4>
            <input type="text" name="major_name" id="major_name" />
            <h4>Mô tả ngành</h4>
            <input type="text"  name="major_description" id="major_description">
            <button class="btn btn-success" type="submit">Submit</button>
            <a href="{{route('major/index')}}" class="btn btn-default">Back</a>
        </form>
        
    </div>

@endsection
@section('script')
    <script>
        
    </script>
@endsection