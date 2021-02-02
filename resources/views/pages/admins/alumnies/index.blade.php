@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
                @if($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <p>{{$message}}</p>
                    <p class="mb-0"></p>
                </div>
                @endif
            <br>
            <a href="{{route('alumnies/create')}}" class="btn btn-success">Add</a>    
            
            <br>
            <div class="div" align="right">
                    <form action="{{ route('alumnies/import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" accept=".xlsx">
                        <button type="submit" class="btn btn-warning">Import</button>
                    </form>
                <form action="{{route('alumnies/import_register_graduate')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file_graduate" id="file_graduate">
                    <button type="submit" class="btn btn-danger">Import Graduate</button>
                </form> 
            </div>
            <div class="table-responsive">
                <table id="table_students" class="table display">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>MSSV</th>
                            <th>Khóa</th>
                            <th>Họ và tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Giới tính</th>
                            <th>Ngày sinh</th>
                            <th>Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th>Lý do</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $row)
                            <tr>
                                <td>{{$row->user_id}}</td>
                                <td>{{$row->code}}</td>
                                <td>{{$row->course}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->tel}}</td>
                                <td><a href="mailto:{{$row->email}}">{{$row->email}}</a></td>
                                @if ($row->gender === 'N')
                                    <td>Nữ</td>
                                @else
                                    <td>Nam</td>
                                @endif
                                <td>{{$row->birth}}</td>
                                <td>{{$row->address}}</td>
                                <td>
                                    @foreach ($row->statuses as $status)
                                        {{$status['status_name']}}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($row->statuses as $status)
                                        {{$status['status_reason']}}
                                    @endforeach
                                </td>
                                <td>
                                    <form action="{{ route('alumnies/destroy', $row->user_id) }}" method="post" class="delete_form">
                                            
                                        <a href="{{route('alumnies/show',$row->user_id)}}" data-toggle="tooltip"  data-original-title="Show"><i class="icon-user"></i></a>
                                        <a href="{{route('alumnies/edit',$row->user_id)}}" data-toggle="tooltip"  data-original-title="Edit"><i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table_students').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            }); 
    });
    $('.delete_form').on('submit',function(){
            if(confirm('Bạn có muốn xóa sinh viên này?'))
            {
                return true;
            }
            else
            {
                return false;
            }
    });
</script>
    
@endsection