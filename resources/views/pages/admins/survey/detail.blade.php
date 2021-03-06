@extends('layouts.admin')
@section('content')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@if($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        <p>{{$message}}</p>
        <p class="mb-0"></p>
    </div>
    @endif
    @if($message = Session::get('error'))
    <div class="alert alert-danger" role="alert">
        <p>{{$message}}</p>
        <p class="mb-0"></p>
    </div>
    @endif
  <div class="card">
      <div class="card-content p-20">
      {{-- <p>Survey title</p> --}}
      <p class="h1 p-0-0-10-0">{{ $survey->survey_name }}</p> 
      {{-- <p>Survey discription</p> --}}
      <p class="h3">{{ $survey->survey_description }}</p>
      <br/>
      <a href='view/{{$survey->survey_id}}' class="btn btn-success">Take Survey</a> 
      <a href="{{$survey->survey_id}}/edit" class="btn btn-warning">Edit Survey</a>
      <a href="{{route('view.survey.answers',$survey->survey_id)}}" class="btn btn-primary">View Answers</a>

      <div class="divider" style="margin:20px 0px;"></div>
      <p class="flow-text center-align">Questions</p>
      <ul class="collapsible" data-collapsible="expandable">

          {{-- {{dd($survey->questions)}} --}}

          @forelse ($survey->questions as  $question)
          {{-- {{ $question}} --}}
          {{-- {{dd($question)}} --}}

          <table class="table table-responsive  ">
            <tr>
              <td>{{$question->question_title}}</td>
            <td><span class="collapsible-header"><a href="{{route('question.edit',$question->question_id)}}" >Edit</a></span></td>
            </tr>
          </table>

            
            <div class="collapsible-body">
              <div style="margin:5px; padding:10px;">
                  {{-- <div>{{$question['question_type']}}</div> --}}
                  {{-- {!! Form::open() !!}
                    @if($question['question_type'] === 'text')
                      {{ Form::text('question_title')}}

                    @elseif($question['question_type'] === 'textarea')
                    <div class="row">
                      <div class="input-field col s12">
                        <textarea id="textarea1" class="materialize-textarea" rows="5"></textarea>
                        <label for="textarea1">Provide answer</label>
                      </div>
                    </div>

                    @elseif($question['question_type'] === 'radio')
                      @foreach($question->question_option as $key=>$value)
                        <p style="margin:0px; padding:0px;">
                          <input type="radio" id="{{ $key }}" />
                          <label for="{{ $key }}">{{ $value }}</label>
                        </p>
                      @endforeach

                    @elseif($question['question_type'] === 'checkbox')
                      @foreach($question->question_option as $key=>$value)
                      <p style="margin:0px; padding:0px;">
                        <input type="checkbox" id="{{ $key }}" />
                        <label for="{{$key}}">{{ $value }}</label>
                      </p>
                      @endforeach
                    @endif 
                  {!! Form::close() !!} --}}
              </div>
            </div>
          {{-- </li> --}}
          @empty
            <span style="padding:10px;">Nothing to show. Add questions below.</span>
          
          @endforelse
      </ul>

      <h2 class="flow-text">Add Question</h2>

      <form method="POST" action="{{route('survey.store',$survey)}}" id="boolean">
        @csrf
        {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
        
        {{-- <div class="row text-left"> --}}
          <div class="input-field col s12">
            <select class="browser-default" name="question_type" id="question_type">
              {{-- <option value="" disabled selected>Choose your option</option> --}}
              <option value="Text">Text</option>
              <option value="Textarea">Textarea</option>
              <option value="Checkbox">Checkbox</option>
              <option value="Radio">Radio</option>
            </select>
          </div>                
          
          <div class="input-field col s12 ">
            <br>
            <label for="question_title">Question</label> <br>
            <label>
            <input name="question_title" id="question_title" type="text" class="text-left">
            {{-- <label class="checkbox-inline"> --}}
                &nbsp;&nbsp;&nbsp;Bắt buộc: 
            <input type="checkbox" checked data-toggle="toggle" data-onstyle="info" id='question_mandatory' name='question_mandatory' value="1">
            {{-- </label> --}}
            </label>
            
            
          </div>  
          <!-- this part will be chewed by script in init.js -->
          <div class="form-g" id="form-g"></div>
          <div class="scroll" id="scroll"></div>
          <div class="input-field col s12">
            <br>
          <button class="btn waves-effect btn btn-success text-left" id='submit'>Submit</button>
          </div>
        </div>
        </form>
    </div>
  </div>
  <script src="{{ URL::asset('public\jquery-3.4.1.min.js') }}"></script>
  {{-- link nút toggle --}}
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <script >
 
      // for adding new option
  $(document).on('click', '.add-option', function() {
      $(".form-g").append(material);
      // scrollBot:(".form-g").get(0).scrollHeight;
      $('html').animate({scrollTop: $('.scroll').offset().top},1000);
    });
    $(document).on('load', function() {
      $('html').animate({scrollTop: $('.scroll').offset().top},1000);
    });
  
    // will replace .form-g class when referenced
    var material = '<div class="input-field col input-g s12"><br>' +
      '<input name="question_option[]" id="question_option[]" type="text" placeholder="Options">' +
      '<span style="margin-left:50px; color:red; cursor:pointer;"class="delete-option">Delete</span><br>' +
      // '<label for="question_option">Options</label><br>' +
      '<p class="add-option" style="cursor:pointer; color:green; margin-top:5px" onclick="scroll()">Add Another</p>' +
      '</div>';
      $(document).on('click', '.delete-option', function() {
      $(this).parent(".input-field").remove();
      });


      $(document).on('click', '.add-option', function() {
        // $( document ).scroll();
        $(window).scrolldown()
        // $('#slideshow').animate({scrollDown: "+=400"});
      });
      // $(document).on('function(){  // or $(document).on('mousemove', function(e){
      //   var mp = e.pageX;
      //   var w = $(window).width() / 2;
      //   if (mp < w) {
      //         $('#slideshow').animate({scrollLeft: "+=400"});
      //   } else {
      //         $('#slideshow').animate({scrollLeft: "-=400"});
      //   } 
      // });
    // allow for more options if radio or checkbox is enabled
    $(document).on('change', '#question_type', function() {
      var selected_option = $('#question_type :selected').val();
      if (selected_option === "Radio" || selected_option === "Checkbox") {
        $(".form-g").html(material);
        $('html').animate({scrollTop: $('.add-option').offset().top},1000);
      } else {
        $(".input-g").remove();
      }
    });
   
  
  </script>
    
@stop