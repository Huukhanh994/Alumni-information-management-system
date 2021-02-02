<!-- Left navbar-header -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
    <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
    </span> </div>
                <!-- /input-group -->
            </li>
            {{-- TODO: QUẢN LÝ KHOA --}}
            <li> 
                <a href="{{route('khoa-vien/index')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">QUẢN LÝ PHÒNG BAN</span></a> 
                <ul class="nav nav-second-level">
                    <li> <a href="{{route('khoa-vien/index')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">KHOA/VIỆN</span></a> </li>
                    {{-- TODO: QUẢN LÝ NGÀNH --}}
                    <li> <a href="{{route('major/index')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">NGÀNH HỌC</span></a> </li>
                    {{-- TODO: QUẢN LÝ CHUYÊN NGÀNH --}}
                    <li> <a href="{{route('major_branch/index')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">CHUYÊN NGÀNH</span></a> </li>
                    {{-- TODO: QUẢN LÝ LỚP --}}
                    <li> <a href="{{route('class/index')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">LỚP</span></a> </li>
                </ul>
            </li>
            {{-- TODO: QUẢN LÝ THÔNG TIN SINH VIÊN --}}
            <li> <a href="{{route('students.index')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">QUẢN LÝ SINH VIÊN</span></a> </li>
            {{-- TODO: QUẢN LÝ THÔNG TIN CỰU SINH VIÊN --}}
            <li> <a href="{{route('alumnies/index')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">QUẢN LÝ CỰU SINH VIÊN</span></a> </li>
            {{-- TODO: QUẢN LÝ BÀI ĐĂNG --}}
            <li> 
                <a href="{{route('posts.index')}}" class="waves-effect posts"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">QUẢN LÝ BÀI ĐĂNG</span></a> 
                <ul class="nav nav-second-level" class="sub-menu">
                    <li><a href="{{route('posts.index')}}">BẢN TIN</a></li>
                    <li><a href="{{route('posts.add_posts')}}">ĐĂNG BÀI</a></li>
                    <li><a href="javascript:void(0)" class="waves-effect">DANH SÁCH BẢN TIN<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li> <a href="{{route('posts.categories_find_job')}}">TÌM VIỆC LÀM</a></li>
                            <li> <a href="{{route('posts.categories_apply_job')}}">TUYỂN DỤNG VIỆC LÀM</a></li>
                            <li> <a href="{{route('posts.categories_class_meeting')}}">HỌP LỚP</a></li>
                            <li> <a href="{{route('posts.categories_support_scholarship')}}">HỖ TRỢ HỌC BỔNG</a></li>
                            <li> <a href="{{route('posts.categories_donations')}}">HỖ TRỢ TRANG THIẾT BỊ</a></li>
                            <li> <a href="{{route('posts.categories_notifications')}}">THÔNG BÁO KHÁC</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route('posts.list_post')}}">DUYỆT BÀI</a></li>
                    <li><a href="{{route('posts.list_post_students')}}">BÀI TIN CHO SINH VIÊN</a></li>
                    <li><a href="{{route('posts.list_post_teachers')}}">BẢN TIN CHO GIẢNG VIÊN</a></li>
                    {{-- <li><a href="{{route('posts.post_yourself')}}">Bài đăng của mình đăng</a></li> --}}
                    @if (Auth::check())
                        <li><a href="{{route('posts.post_your_class',Auth::user()->user_id)}}">BÀI TIN TRÊN LỚP CỦA SINH VIÊN</a></li>
                    @endif
                    <li><a href="{{route('posts.lists_account_blocked')}}">TÀI KHOẢN BỊ KHÓA</a></li>
                </ul> 
            </li>
            {{-- TODO: QUẢN LÝ KHẢO SÁT --}}
            <li> <a href="{{route('survey.index')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">QUẢN LÝ KHẢO SÁT</span></a> </li>
            {{-- SEND EMAIL --}}
            <li> <a href="{{route('mails.index')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">GMAIL</span></a> </li>
            {{-- TODO: QUẢN LÝ THỐNG KÊ --}}
            <li> 
                <a href="{{route('statistic.student')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">QUẢN LÝ THỐNG KÊ</span></a>
                <ul class="nav nav-second-level"> 
                    {{-- TODO: THỐNG KÊ SINH VIÊN TỐT NGHIỆP --}}
                    <li> <a href="{{route('statistic.student')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Tốt nghiệp</span></a> </li>
                    {{-- TODO: THỐNG KÊ THEO FORM --}}
                    <li> <a href="{{route('statistic')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Theo form</span></a> </li>
                </ul>
            </li>
            {{-- PHÂN QUYỀN  --}}
            <li> <a href="{{route('permissions/index')}}" class="waves-effect"><i data-icon="P" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">PHÂN QUYỀN</span></a> </li>
        </ul>
    </div>
</div>
<!-- Left navbar-header end -->
