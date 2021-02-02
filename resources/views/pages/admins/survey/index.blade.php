@extends('layouts.admin')
@section('content')
<div id="page-wrapper">
        @if($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            <p>{{$message}}</p>
            <p class="mb-0"></p>
        </div>
        @endif
        @if($message = Session::get('error'))
        <div class="alert alert-danger  " role="alert">
            <p>{{$message}}</p>
            <p class="mb-0"></p>
        </div>
        @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                    <h3 class="box-title">Survey Table</h3>
                    <br>
                    
                    <a href="{{route('survey.create_render')}}" class="btn btn-success waves-effect waves-light m-r-10">Add Survey</a>
                    <br>
                    <br>
                    <br>
                    <div class="table-responsive">
                        <table class="table color-table primary-table">
                            <thead>
                                <tr>
                                    <th>Survey Version:</th>
                                    <th>Survey Title:</th>
                                    <th>Survey Start:</th>
                                    <th>Survey End:</th>
                                    <th>Creator Name:</th>
                                    <th>Creator Code:</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($survey as $item)
                                    <tr>
                                        <td>{{$item->survey_version}}</td>
                                        <td>{{$item->survey_name}}</td>
                                        <td>{{$item->survey_start}}</td>
                                        <td>{{$item->survey_end}}</td>
                                        <td>{{$item->users['name']}}</td>
                                        <td>{{$item->users['code']}}</td>
                                        <td>
                                            <form action="{{ route('survey/destroy', $item->survey_id) }}" method="post" class="delete_form">
                                                <a href='{{route('survey.view',$item->survey_id)}}' class="btn btn-info">Take Survey</a>
                                                <a href="{{route('survey.detail',$item->survey_id)}}" class="btn btn-success">Add Question</a>
                                                <a href="{{route('view.survey.answers',$item->survey_id)}}" class="btn btn-primary">Show Answer</a>
                                                <a href="{{ action('Master\SurveyController@edit',$item->survey_id) }}" class="btn btn-warning">Edit</a>
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
            {{-- end div col-sm-6 --}}
        </div> 
        {{-- end div row --}}
    </div>
    {{-- end div container-fluid --}}
</div>
{{-- end div page-wrapper --}}

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