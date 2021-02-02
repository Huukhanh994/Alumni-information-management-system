@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h2 class="box-title m-b-0">Thông tin cựu sinh viên đã tốt nghiệp</h2>
            <br>
            <br>
            <form class="form" action="{{route('alumnies/show_submit',$alumni_id)}}">
                <div class="form-group row">
                    <label for="example-text-input" class="col-2 col-form-label">MSSV</label>
                    <div class="col-10">
                    <input class="form-control" type="text" value="{{$alumnies->code}}" id="example-text-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Khóa</label>
                    <div class="col-10">
                        <input class="form-control" type="text" value="{{$alumnies->course}}" id="example-search-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-email-input" class="col-2 col-form-label">Họ và tên</label>
                    <div class="col-10">
                        <input class="form-control" type="text" value="{{$alumnies->name}}" id="example-email-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-url-input" class="col-2 col-form-label">SĐT</label>
                    <div class="col-10">
                        <input class="form-control" type="tel" value="{{$alumnies->tel}}" id="example-url-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-tel-input" class="col-2 col-form-label">Email</label>
                    <div class="col-10">
                        <input class="form-control" type="text" value="{{$alumnies->email}}" id="example-tel-input">
                    </div>
                </div>
                @if (isset($alumni))
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-2 col-form-label">Mã lớp</label>
                        <div class="col-10">
                            <input class="form-control" type="text" value="{{$alumni->class_code}}" id="example-tel-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-2 col-form-label">Tên lớp</label>
                        <div class="col-10">
                            <input class="form-control" type="text" value="{{$alumni->class_name}}" id="example-tel-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-2 col-form-label">Tên nghành</label>
                        <div class="col-10">
                            <input class="form-control" type="text" value="{{$alumni->major_name}}" id="example-tel-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-2 col-form-label">Tên chuyên nghành</label>
                        <div class="col-10">
                            <input class="form-control" type="text" value="{{$alumni->major_branch_name}}" id="example-tel-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-2 col-form-label">Tên khoa</label>
                        <div class="col-10">
                            <input class="form-control" type="text" value="{{$alumni->academy_name}}" id="example-tel-input">
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-2 col-form-label">Mã lớp</label>
                        <div class="col-10">
                            <input class="form-control" type="text" value="" id="example-tel-input" placeholder="Chưa xét">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-2 col-form-label">Tên lớp</label>
                        <div class="col-10">
                            <input class="form-control" type="text" value="" id="example-tel-input" placeholder="Chưa xét">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-2 col-form-label">Tên nghành</label>
                        <div class="col-10">
                            <input class="form-control" type="text" value="" id="example-tel-input" placeholder="Chưa xét">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-2 col-form-label">Tên chuyên nghành</label>
                        <div class="col-10">
                            <input class="form-control" type="text" value="" id="example-tel-input" placeholder="Chưa xét">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-2 col-form-label">Tên khoa</label>
                        <div class="col-10">
                            <input class="form-control" type="text" value="" id="example-tel-input" placeholder="Chưa xét">
                        </div>
                    </div>
                @endif
                
                @if (isset($alumnies->gender))
                <div class="form-group row">
                    <label for="example-password-input" class="col-2 col-form-label">Phái</label>
                    <div class="col-10">
                        <input class="form-control" type="text" value="{{$alumnies->gender}}" id="example-password-input">
                    </div>
                </div>
                @else
                <div class="form-group row">
                    <label for="example-password-input" class="col-2 col-form-label">Phái</label>
                    <div class="col-10">
                        <input class="form-control" type="text" value="Nam" id="example-password-input">
                    </div>
                </div>
                @endif
                
                <div class="form-group row">
                    <label for="example-number-input" class="col-2 col-form-label">Ngày sinh</label>
                    <div class="col-10">
                        <input class="form-control" type="date" value="{{$alumnies->birth}}" id="example-number-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-datetime-local-input" class="col-2 col-form-label">Đia chỉ</label>
                    <div class="col-10">
                        <input class="form-control" type="text" value="{{$alumnies->address}}" id="example-datetime-local-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-datetime-local-input" class="col-2 col-form-label">Tôn giáo</label>
                    <div class="col-10">
                        <input class="form-control" type="text" value="{{$alumnies->nation}}" id="example-datetime-local-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-datetime-local-input" class="col-2 col-form-label">Gia đình SDT</label>
                    <div class="col-10">
                        <input class="form-control" type="text" value="{{$alumnies->family_tel}}" id="example-datetime-local-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-datetime-local-input" class="col-2 col-form-label">Gia đình địa chỉ</label>
                    <div class="col-10">
                        <input class="form-control" type="text" value="{{$alumnies->family_address}}" id="example-datetime-local-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-date-input" class="col-2 col-form-label">Tình trạng</label>
                    <div class="col-10">
                        <input class="form-control" type="text" value="{{$status_name}}" id="example-date-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-month-input" class="col-2 col-form-label">Lý do</label>
                    <div class="col-10">
                        <input class="form-control" type="text" value="{{$status_reason}}" id="example-month-input">
                    </div>
                </div>
                @if(isset($alumnies_graduates))
                    @foreach ($alumnies_graduates as $row)
                        <div class="form-group row">
                            <label for="example-week-input" class="col-2 col-form-label">Học kỳ TN</label>
                            <div class="col-10">
                            <input class="form-control" type="text" value="{{$row->register_graduate_phase}}" id="example-week-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-time-input" class="col-2 col-form-label">Quyết định</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="{{$row->register_graduate_decision}}" id="example-time-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-color-input" class="col-2 col-form-label">Ngày TN</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="{{$row->register_graduate_date}}" id="example-color-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-color-input" class="col-2 col-form-label">AUN</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="{{$row->register_graduate_AUN}}" id="example-color-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Điểm TB</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="{{$row->register_graduate_GPA}}" id="example-text-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Điểm rèn luyện</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="{{$row->register_graduate_DRL}}" id="example-text-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Tổng TCTN</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="{{$row->register_graduate_TCTL}}" id="example-text-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Xếp loại</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="{{$row->register_graduate_ranked}}" id="example-text-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Danh hiệu</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="{{$row->register_graduate_degree}}" id="example-text-input">
                            </div>
                        </div> 
                    @endforeach
                @endif
                 
                <div class="form-group">
                    <a href="{{route('alumnies/index')}}" class="btn btn-default">Back</a>
                    @foreach ($alumnies->statuses as $alumni)
                        @if ($alumni->status_id === 3)
                        <a href="{{route('alumnies/show_details_work',$alumni_id)}}" class="btn btn-primary">Show Details Work</a>
                        @endif
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.row -->
    
@endsection