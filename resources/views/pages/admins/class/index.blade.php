@extends('layouts.admin')
@section('content')
    <div class="row">
            @if($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                <p>{{$message}}</p>
                <p class="mb-0"></p>
            </div>
            @endif
        <div class="col-sm-12">
            <div class="white-box">
                <table id="myTable" class="table table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info">
                        <br>
                        <a href="{{route('class/create')}}" class="btn btn-success">Add</a>
                        <br>
                        <thead>
                            {{-- <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="myTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Code: activate to sort column descending" style="width: 104px;"></th> --}}
                                <th class="sorting" tabindex="0" aria-controls="myTable" rowspan="1" colspan="1" aria-label="Class ID: activate to sort column ascending" style="width: 202px">ID Lớp:</th>
                                <th class="sorting" tabindex="0" aria-controls="myTable" rowspan="1" colspan="1" aria-label="Class Code: activate to sort column ascending" style="width: 202px;">Mã lớp</th>
                                <th class="sorting" tabindex="0" aria-controls="myTable" rowspan="1" colspan="1" aria-label="Class Name: activate to sort column ascending" style="width: 205px;">Tên lớp</th>
                                <th class="sorting" tabindex="0" aria-controls="myTable" rowspan="1" colspan="1" aria-label="School Year Begin: activate to sort column ascending" style="width: 414px">Năm bất đầu</th>
                                <th class="sorting" tabindex="0" aria-controls="myTable" rowspan="1" colspan="1" aria-label="School Year End: activate to sort column ascending" style="width: 414px">Năm kết thúc</th>
                                <th class="sorting" tabindex="0" aria-controls="myTable" rowspan="1" colspan="1" aria-label="Major Branch: activate to sort column ascending" style="width: 414px;">Tên Chuyên nghành</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{$item['class_id']}}</td>
                                    <td>{{$item['class_code']}}</td>
                                    <td>{{$item['class_name']}}</td>
                                    <td>{{$item['class_begin']}}</td>
                                    <td>{{$item['class_end']}}</td>
                                        @foreach($major_branch_name as $name)
                                            @if ( $name->major_branch_id == $item['major_branch_id'] )
                                                <td>{{$name->major_branch_name}}</td>
                                            @endif
                                        @endforeach
                                    <td>
                                    <form action="{{ route('class/destroy', $item->class_id) }}" method="post" class="delete_form">
                                        @csrf
                                        <a href="{{ route('class/show', $item->class_id) }}" class="btn btn-primary">Show</a>
                                        <a href="{{ route('class/edit', $item->class_id) }}" class="btn btn-warning">Edit</a>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
<script type="text/javascript">
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
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        
    });
</script>

@endsection