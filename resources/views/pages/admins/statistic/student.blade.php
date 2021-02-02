@extends('layouts.admin')
@section('content')




<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                    <h3 class="box-title">Thống kê tỉ lệ tốt nghiệp của sinh viên</h3>
                    <br>
                    <br>
                    <div>
                            <form action="{{route('statistic.student_sort')}}" method="post">
                                @csrf
                                <div class="container-fluid ">
                                    <table class="">
                                        <tr><td>Khóa &nbsp;</td>
                                            <td><select name="course" id="course" style="width: 300px;"  >
                                                    <option value="all" selected>Tất cả</option>
                                                    @foreach($course as $y)
                                                        <option value="{{$y->year}}">{{$y->year-1974}}</option>
                                                    @endforeach
                                                    
                                            </select>
                                            <td>Ngành &nbsp;</td>
                                            <td>
                                           <select name="major"  id="major" style="width: 300px;" >
                                                <option value="all">Tất cả</option>
                                                @foreach($major as $item)
                                                    <option value="{{$item->major_id}}">{{$item->major_name}}</option>
                                                @endforeach
                                            </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>Chuyên ngành &nbsp;</td>
                                            <td>
                                            <select name="major_branch" id="major_branch" style="width: 300px;" >
                                                <option value="all">Tất cả</option>
                                            </select>
                                            </td>
                                        </tr>
                                        <tr>
                                                <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>Lớp &nbsp;</td>
                                            <td>
                                            <select name="class" id="class" style="width: 300px;">
                                                <option value="all">Tất cả</option>
                                            </select>
                                            </td>
                                        </tr>
                                        
                                    </table>
                                        

                                        <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table color-table primary-table">
                            <thead>
                                <tr>
                                    <th>Tổng số lượng sinh viên</th>
                                    <th>Số lượng sinh viên đã tốt nghiệp</th>
                                    <th>Tỉ lệ tốt nghiệp</th>
                                </tr>
                            </thead>
                            <tbody>
                               <tr>
                                <td>{{$total_student}}</td>
                                <td>{{$register_graduate_pass}}</td>
                                <td>{{$per}} %</td>
                               </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div> 
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function(){
        // Ajax
        $("#major").change(function(){
            var major_id = $(this).val();
            $.get("../statistic/major_branch/"+major_id, function(data){
                $("#major_branch").html(data);
            });
        });
        
        // Ajax
        $("#major,#major_branch,#course").change(function(){
            var major_id = $("#major").val();
            var major_branch_id = $("#major_branch").val();
            var course = $("#course").val();
            $.get("../statistic/class/"+major_id+'/'+major_branch_id+'/'+course, function(data){
                $("#class").html(data);
            });
            
        });
    });
</script>
@endsection