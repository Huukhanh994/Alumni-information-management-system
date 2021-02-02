@extends('layouts.admin')
@section('content')
<!-- Page Content -->
<div class="row">
<div class="col-sm-12">
    <div class="white-box">
        <br>
        <br>
        <a href="{{route('students.create')}}" class="btn btn-success">Add</a>
        <br>
        <div class="card-body" align="right">
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-warning">Import</button>
            </form>
        </div>
        <div class="table-responsive">
            <table id="table_students" class="table display">
                <thead>
                    <tr>
                        <th>MSSV</th>
                        <th>Họ và tên</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Mã lớp</th>
                        <th>Tên lớp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $row)
                        <tr>
                            <td>{{$row->code}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->tel}}</td>
                            <td>{{$row->email}}</td>
                            <td>
                                @foreach ($row->classes as $item)
                                    {{$item->class_code}}
                                @endforeach
                            </td>
                            <td>
                                @foreach ($row->classes as $item)
                                    {{$item->class_name}}
                                @endforeach
                            </td>
                            <td>
                                <form action="{{ route('students.destroy', $row->user_id) }}" method="post" class="delete_form">
                                        
                                    <a href="{{route('students.show',$row->user_id)}}" data-toggle="tooltip"  data-original-title="Show"><i class="icon-user"></i></a>
                                    <a href="{{route('students.edit',$row->user_id)}}" data-toggle="tooltip"  data-original-title="Edit"><i class="fa fa-pencil text-inverse m-r-10"></i></a>
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
<script type="text/javascript">
    $(document).ready(function () {
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
    });
    // SEARCH LIVE 
    // $(document).ready(function () {
    //     fetch_student_data();
    //     function fetch_student_data(query ='')
    //     {
    //         $.ajax({
    //             type: "GET",
    //             url: "{{route('students.live_search_action')}}",
    //             data: {query:query},
    //             dataType: "JSON",
    //             success: function (response) {
    //                 $('tbody').html(response.table_data)
    //                 $('#total_records').text(response.total_data);
    //             }
    //         });
    //     }
    //     $(document).on('keyup','#search',function(){
    //         var query = $(this).val();
    //         fetch_student_data(query);
    //     })
    // });
</script>
<script>
    $(document).ready(function () {
        $('#table_students').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            }); 
    });
    // $(document).ready(function() {
    //     $('#table_pagination').DataTable({
    //         processing: true,
    //         serverside: true,
    //         ajax: {
    //             url : "{{route('students.index')}}",
    //         },
    //         columns: [
    //             {
    //                 data: code,
    //                 name: code,
    //             },
    //             {
    //                 data: first_name,
    //                 name: first_name,
    //             },
    //             {
    //                 data: last_name,
    //                 name: last_name,
    //             },
    //             {
    //                 data: username,
    //                 name: username,
    //             },
    //             {
    //                 data: password,
    //                 name: password,
    //             },
    //             {
    //                 data: tel,
    //                 name: tel,
    //             },
    //             {
    //                 data: email,
    //                 name: email,
    //             },
    //             {
    //                 data: active_code,
    //                 name: active_code,
    //             },
    //             {
    //                 data: gender,
    //                 name: gender,
    //             },
    //             {
    //                 data: birthday,
    //                 name: birthday,
    //             },

    //         ]

    //     });
        
    // });
</script>

@endsection