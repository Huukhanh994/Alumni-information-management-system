@extends('layouts.admin')
@section('content')
<!-- .row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">DANH SÁCH CÁC ROUTE</h3>
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
                @if($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{{$message}}</p>
                    <p class="mb-0"></p>
                </div>
                @endif
                <form action="{{route('permissions/store')}}" method="post">
                    @csrf
                    <table id="demo-foo-addrow" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                        <thead>
                            <tr>
                                <th>Route ID</th>
                                <th data-hide="phone, tablet">Danh sách liên kết</th>
                                <th data-sort-ignore="true" class="min-width">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($routes as $row)
                                <tr>
                                    <td>{{$row->route_id}}</td>
                                    <td>{{$row->route_link}} , {{$row->route_name}}</td>
                                    <td>
                                        <div class="checkbox checkbox-info" align="center">
                                            <input type="checkbox" name="route_id[]" value="{{$row->route_id}}"> 
                                            <label for="route_id"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="hidden" name="role_id" value="{{$role_id}}">
                                    </td>
                                </tr>  
                            @endforeach
                    </table>
                    <div class="form-group" align="right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-success">Reset</button>
                        <a href="{{route('permissions/index')}}" class="btn btn-default">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->
@endsection