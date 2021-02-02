@extends('layouts.admin')
@section('content')
<!-- .row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">PHÂN QUYỀN CỰU SINH VIÊN</h3>
                <div class="form-inline padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <a href="{{route('permissions/create')}}" class="btn btn-success">Thêm phân quyền mới</a>
                                    
                                </div>    
                            </div>
                            <div class="col-sm-6 text-right m-b-20">
                                <div class="form-group">
                                    <input id="demo-input-search2" type="text" placeholder="Search" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                <table id="demo-foo-addrow" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                    <thead>
                        <tr>
                            <th data-sort-initial="true" data-toggle="true">STT</th>
                            <th>Tên phân quyền</th>
                            <th data-hide="phone, tablet">Route link</th>
                            <th data-hide="phone, tablet">Route name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($role_alumni as $row)
                            <tr>
                                <td>{{$row->permission_id}}</td>
                                <td>
                                    @foreach ($row->role as $item)
                                        {{$item->role_name}}
                                    @endforeach
                                </td>
                            
                                @foreach ($row->route as $item)
                                    <td>{{$item->route_link}}</td>
                                    <td>{{$item->route_name}}</td>
                                    
                                @endforeach

                            </tr>  
                        @endforeach

                </table>
            </div>
        </div>
    </div>
    <!-- /.row -->
@endsection