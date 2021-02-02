@extends('layouts.admin')
@section('content')
<form method="POST" action="{{route('question.update',$question->question_id)}}">
  @csrf
  {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
  <h2 class="flow-text">Edit Question Title</h2>
   {{-- <div class="row"> --}}
    {{-- <div class="input-field col s12"> --}}
      {{-- <input type="text" name="question_title" id="question_title" value="{{ $question->question_title }}">
      <label for="tiquestion_titletle">Question</label> --}}
    {{-- </div> --}}
    
    @if($question->question_type === 'Text')
        <div class="input-field col s12">
        <label for="question_title">Question</label> <br>
        <input type="Text" name="question_title" id="question_title" value="{{ $question->question_title }}">
        {{-- <div class="input-field col s12">
          <input id="answer" type="text" name="{{$question->question_id}}"> --}}
        </div>

      @elseif($question->question_type === 'Textarea')
        <div class="input-field col s12">
          <label for="question_title">Question</label> <br>
          <textarea id="question_title" name="question_title" class="materialize-textarea" value="{{$question->question_title}}"></textarea>
          <label for="Textarea">Textarea</label>
        </div>

      @elseif($question->question_type === 'Radio')
        <label for="question_title">Question</label> 
        <input type="text" name="question_title" id="question_title" value="{{ $question->question_title }}"><br><br>
        {{-- decode --}}
        <?php $option=json_decode($question->question_option,true); ?>
        @foreach ($option as $item=>$value)
          @if(is_array($value))
            @foreach ($value as $item1=>$value1)
            <label><input type="radio"></label><label> <input name="option[]" type="Text" id="{{ $item1 }}" value="{{ $value1 }}" /> 
              <a style="margin-left:50px; color:red; cursor:pointer;"class="delete-option" 
              href="{{route('question.delete',['question_id'=>$question_id,'item1'=>$item1])}}">Delete</a>
            </label><br>
            @endforeach
          @endif
        @endforeach
          
        <div class="form-g" id="form-g"></div>
        <p class="add-option" style="cursor:pointer; color:green; margin-top:5px">Add Another</p>

      @elseif($question->question_type === 'Checkbox')
        <label for="question_title">Question</label>
        {{-- chưa xóa được --}}
        <input type="text" name="question_title" id="question_title" value="{{ $question->question_title }}"><br><br>
        {{-- decode --}}
        <?php $option=json_decode($question->question_option,true);?>
        {{-- {{dd($option)}} --}}
        @foreach ($option as $item=>$value)
          @if(is_array($value))
            @foreach ($value as $item1=>$value1)
            <label><input type="checkbox"></label><label> <input name="option[]" type="Text" id="{{ $item1 }}" value="{{ $value1 }}" /> 
            <a style="margin-left:50px; color:red; cursor:pointer;"class="delete-option" 
            href="{{route('question.delete',['question_id'=>$question_id,'item1'=>$item1])}}">Delete</a>
          </label>
              <br>
            @endforeach
          @endif
        @endforeach

          <div class="form-g" id="form-g"></div>
          <p class="add-option" style="cursor:pointer; color:green; margin-top:5px">Add Another</p>
      @endif 
    </div>       
    <div class="input-field col s12">
    <button class="btn waves-effect waves-light">Update</button>
    <a href="{{route('survey.detail',$question->surveys['survey_id'])}}" class="btn btn-default">Back</a>
    </div>
  </div>
</form>
@endsection
<script src="{{ URL::asset('public\jquery-3.4.1.min.js') }}"></script>
<script >
    // for adding new option
$(document).on('click', '.add-option', function() {
    $(".form-g").append(material);
  });

  // will replace .form-g class when referenced
  var material = '<div class="input-field col input-g s12"><br>' +
    '<input name="option[]"  type="text" placeholder="Options" >' +
    '<span style="margin-left:50px; color:red; cursor:pointer;"class="delete-option">Delete</span><br>' +
    // '<label for="question_option">Options</label><br>' +
  
    '</div>';
    $(document).on('click', '.delete-option', function() {
    $(this).parent(".input-field").remove();
    });
    $('form-g').scrollspy({target: ".submit"})

</script>