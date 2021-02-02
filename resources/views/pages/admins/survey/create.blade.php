@extends('layouts.admin')
@section('content')
  @if (count($errors) > 0)
     <div class="alert alert-danger" role="alert">
        <ul>
          @foreach ($errors->all() as $error)
             <li>{{  $error}}    </li>
          @endforeach
        </ul>
      </div>
  @endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <form action="create_submit" method="post" id="boolean">
        @csrf
            <h4>Tiêu đề khảo sát</h4>
            <input type="text"  name="survey_name" id="survey_name">

            <h4>Ngày Bắt Đầu</h4>
            <input type="date"  name="survey_start" id="survey_start">

            <h4>Ngày Kết Thúc</h4>
            <input type="date"  name="survey_end" id="survey_end">

            <h4>Mô tả</h4>
            <textarea name="survey_description" id="survey_description" class="materialize-textarea"></textarea>

            <h4>Phiên bản</h4>
            <input type="text" name="survey_version" id="survey_version" type="text"><br>

            <button class="btn btn-success" type="submit">Submit</button>
            <a href="{{route('survey.index')}}" class="btn btn-default">Back</a>
    </form>  
    </div>
  <!-- </form> -->
<!-- </div> -->
<!-- </div> -->

@endsection
@section('script')
    <script>
        
    </script>
@endsection