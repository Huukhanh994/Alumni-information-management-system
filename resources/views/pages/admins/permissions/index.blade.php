@extends('layouts.admin')
@section('content')
<!--row -->
<div class="row">
    @foreach ($roles as $row)
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="m-b-0 box-title">{{$row->role_note}}</h3>
                <p class="text-muted m-b-30">Cố vấn một lớp trong hệ thống</p>
                <div class="button-box">
                    <a href="{{route('permissions/create')}}"><i class="ti-settings"></i></a>
                    <a href="{{route('permissions/show',$row->role_id)}}"><i class="ti-new-window"></i></a>
                </div>
            </div>
        </div>
    @endforeach

    {{-- <div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="white-box">
            <h3 class="m-b-0 box-title">Quản trị viên</h3>
            <p class="text-muted m-b-30">Chịu toàn trách nhiệm cho sự vận hàng hệ thống</p>
            <div class="button-box">
                    <a href="{{route('permissions/index_role_admin')}}"><i class="ti-settings"></i></a>
                    <a href="{{route('permissions/show')}}"><i class="ti-new-window"></i></a>
                </div>
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="white-box">
            <h3 class="m-b-0 box-title">Cựu sinh viên</h3>
            <p class="text-muted m-b-30">Cựu sinh viên đã ra trường</p>
            <div class="button-box">
                    <a href="{{route('permissions/index_role_alumni')}}"><i class="ti-settings"></i></a>
                    <a href="{{route('permissions/show')}}"><i class="ti-new-window"></i></a>
                </div>
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-xs-12">
        <div class="white-box">
            <h3 class="m-b-0 box-title">Sinh viên</h3>
            <p class="text-muted m-b-30">Sinh viên đang học tại trường</p>
            <div class="button-box">
                    <a href="{{route('permissions/index_role_student')}}"><i class="ti-settings"></i></a>
                    <a href="{{route('permissions/show')}}"><i class="ti-new-window"></i></a>
                </div>
        </div>
    </div> --}}
    
</div>
<!--row -->
@endsection