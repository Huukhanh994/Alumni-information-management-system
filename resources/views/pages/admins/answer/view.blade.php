@extends('layouts.admin')
@section('content')
<style>

tbody div{
    overflow: auto!important;
  }
  table{
    height: 1080px;
  }
  .table-responsive.scrollxy {
    height: 720px!important;
    width: 100%;
    overflow-x: scroll;
    overflow-y: scroll;
  }

  </style>
<form action="{{ action('Master\SurveyController@export') }}" method="POST">
  @csrf
  <input type="hidden" name="data" value="{{$survey_json}}">

  <button type="submit" class="btn btn-success">Export</button>
</form>
<h1 style="    color: #2570BB;
font-family: 'Roboto Condensed', Arial, sans-serif;
text-transform: uppercase;">{{ $survey->survey_name }}</h1>
<h4 style="white-space: pre-wrap;
    line-height: 135%;
    margin-top: 22px;
    font-size: 16px;">{{ $survey->survey_description }}</h4>
@csrf
<div class="table-responsive scrollxy">
  
      
  <table class=" table color-table primary-table table-hover" >
    <thead class="thead-dark">
      <tr>
          <th scope="col">User</th>
          <th scope="col">Code</th>
          <th scope="col">Date Create</th>
          @foreach ($survey->questions as $item)
          <th scope="col" >{{ $item->question_title }}</th>
          @endforeach
          
      </tr>
    </thead>
      <tbody>
      
        @forelse ($survey->answers as $answer)
        <tr >
          {{-- hiện thông tin người trả lời --}}
              <td>{{$answer->users['name']}}</td>
              <td>{{$answer->users['code']}}</td>
              <td>{{$answer->created_at}}</td>
          {{-- lấy dữ liệu --}}
          <?php $content=json_decode($answer->answer_content,true); ?>
            @foreach ($content as $item=>$value)
            {{-- nếu là loại câu hỏi checkbox (nhiều đáp án--}}
              @if(count($value)>1)
              <td>
                @foreach ($value as $item1=>$value1)
                  {{$value1}}<br>
                @endforeach
              </td>
              {{-- nếu là các câu hỏi 1 đáp án --}}
              @else 
              @foreach ($value as $item1=>$value1)
                <td>{{$value1}}</td>
              @endforeach
              @endif
            @endforeach
            
          {{-- @endif --}}
          
          {{-- {{dd($contents)}} --}}
          

        {{-- @endforeach --}}
      @empty
        <tr>
          <td>
            No answers provided by you for this Survey
          </td>
          <td></td>
        </tr>
        
      @endforelse
      
        </tr>
    </tbody>
  
    
  </table>
</div>
@endsection

