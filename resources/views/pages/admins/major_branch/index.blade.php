@extends('layouts.admin')
@section('content')
<div id="page-wrapper">
        @if($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            <p>{{$message}}</p>
            <p class="mb-0"></p>
        </div>
        @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                    <h3 class="box-title">Major Branchs Table</h3>
                    <br>
                    <a href="{{route('major_branch/create')}}" class="btn btn-success waves-effect waves-light m-r-10">Add</a>
                    <br>
                    <br>
                    <br>
                    <div class="table-responsive">
                        <table class="table color-table primary-table">
                            <thead>
                                <tr>
                                    <th>Major Branch ID:</th>
                                    <th>Major Name:</th>
                                    <th>Major Branch Name:</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{$item['major_branch_id']}}</td>
                                        @foreach($major_name as $name)
                                            @if ( $name->major_id == $item['major_id'] )
                                                <td>{{$name->major_name}}</td>
                                            @endif
                                        @endforeach
                                        <td>{{$item['major_branch_name']}}</td>
                                        <td>
                                            <form action="{{ route('major_branch/destroy', $item->major_id) }}" method="post" class="delete_form">
                                                <a href="{{ action('Master\MajorBranchController@edit',$item->major_branch_id) }}" class="btn btn-warning">Edit</a>
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