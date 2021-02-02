@extends('layouts.admin')
@section('content')
<div id="page-wrapper">
    @if($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        <p>{{$message}}</p>
        <p class="mb-0"></p>
    </div>
    @endif
    
    <form method="POST" action="{{route('survey.update',$survey->survey_id)}}">
      <!-- {{ method_field('PATCH') }} -->
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <h2 class="flow-text">Edit Survey</h2>

          <fieldset class="form-group row">
              <label class="col-sm-1-12 col-form-label" for="survey_name">Question</label>
              <input type="text" class="form-control" name="survey_name" id="survey_name" value="{{ $survey->survey_name }}">
            </fieldset>

            <fieldset class="form-group row">
                <label class="col-sm-1-12 col-form-label" for="survey_description">Description</label>
                <textarea type="text" class="form-control" name="survey_description" id="survey_description">{{ $survey->survey_description }}</textarea><br>
              </fieldset>

              <fieldset class="form-group row">
                  <label class="col-sm-1-12 col-form-label" for="survey_start">Survey Starting</label>
                  <input type="date" class="form-control" name="survey_start" id="survey_start" value="{{ $survey->survey_start }}"><br>
                </fieldset>

                <fieldset class="form-group row">
                    <label class="col-sm-1-12 col-form-label" for="survey_end">Survey Ending</label>
                    <input type="date" class="form-control" name="survey_end" id="survey_end" value="{{ $survey->survey_end }}"><br>
                  </fieldset>
                  <fieldset class="form-group row">
                      <label class="col-sm-1-12 col-form-label" for="survey_version">Survey Version</label>
                      <input type="text" class="form-control" name="survey_version" id="survey_version" value="{{ $survey->survey_version }}"><br>
                    </fieldset>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
      </div>
    </form>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('.delete_form').on('submit',function(){
            if(confirm('Are you sure delete id??'))
            {
                return true;
            }
            else
            {
                return false;
            }
        });
    });
</script>
@endsection