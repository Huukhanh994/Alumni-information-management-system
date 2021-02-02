@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-8 index">
        @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{  $error}}    </li>
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
    {{-- <p>Welcome to the: {{Auth::user()->name}}</p>
    <p>{{Auth::user()->user_id}}</p> --}}
    @if ($userID === Auth::user()->user_id)
        <script>
            alert('Tài khoản của bạn đã bị khóa!');
        </script>
        <h2 align="center" style="color:#2570BB;">Tài khoản của bạn đã bị khóa, không thể đăng bài</h2>
    @else
        <div class="panel panel-default index">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8 index">
                        <h3 class="panel-title">SOẠN BÀI VIẾT</h3>
                    </div>
                    
                </div>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group" id="dynamic_field">
                        <div class="form-group">
                            <label for="category_id">Chọn thể loại:</label>
                            <select class="form-control" name="category_id" id="category_id">
                                <option value="">Chọn thể loại</option>
                                @foreach ($categories as $item)
                                    <option value="{{$item->category_id}}">{{$item->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="post_link">Link</label>
                            <input type="text" name="post_link" id="post_link" class="form-control" placeholder="Link" aria-describedby="helpId">
                        </div>
                        <div class="form-group">
                            <label for="post_file">Chọn file upload</label>
                            <input type="file" name="post_file[]" id="post_file" class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="form-group">
                            <label for="post_slug">Tên viết tắt bài đăng</label>
                            <input type="text" name="post_slug" id="post_slug" class="form-control" placeholder="Tên viết tắt bài đăng" aria-describedby="helpId">
                        </div>
                        <div class="form-group">
                            <label for="role_name">Đăng trên phân quyền</label>
                            <select class="form-control" name="role_name" id="role_name">
                                <option name="" value="">Chọn phân quyền</option>
                                <option name="admin" value="1">Admin</option>
                                <option name="teacher" value="2">Giảng viên</option>
                                <option name="student" value="3">Sinh viên</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="class_name">Mã lớp:</label>
                            <select class="form-control" name="class_name" id="class_name">
                                <option value="">Chọn mã lớp</option>
                                @foreach ($classes as $item)
                                    <option value="{{$item->class_id}}">{{$item->class_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="post_title">Tiêu đề</label>
                            <input type="text" name="post_title" id="post_title" class="form-control" placeholder="Write your short title" aria-describedby="helpId">
                        </div>
                        <div class="form-group">
                            <label for="post_content">Nội dung</label>
                            <textarea name="post_content" id="post_content" class="form-control" placeholder="Write your short story" style="height:200px"></textarea>
                        </div>
                        
                    </div>
                    <div id="link_content"></div>
                    <div class="form-group" align="right">
                        <input type="submit" name="share_post" id="share_post" class="btn btn-primary" value="Đăng" />
                        <input type="reset" class="btn btn-default" value="Reset">
                    </div>
                </form>
            </div>
        </div>
    @endif
    </div>
    <div class="col-md-4 index">
        <div class="panel panel-default index">
            <div class="panel-heading">
                <h3 class="panel-title">Action</h3>
                Welcome to <span style="color:red;">{{Auth::user()->name}} / ID: {{Auth::user()->user_id}}</span>
                    <br>
                    <hr>
                    {{-- <a href="{{route('posts.login')}}" class="btn btn-default">Login</a>
                    <a href="{{route('posts.login2')}}" class="btn btn-default">Login2</a>
                    <a href="{{route('posts.logout')}}" class="btn btn-success">Logout</a> --}}
            </div>
            <div class="panel-body">
                <div id="user_list"></div>
            </div>
        </div>
        @foreach ($count as $item)
        <div class="panel panel-default index">
            <div class="panel-body">
                <h3>Tên người post: {{$item->user['name']}}</h3>
                <p>ID người post: <b>{{$item->user_id}}</b>. Số lượt post đã đăng: <b>{{$item->user_count}}</b></p>
                {{-- <a href="#" class="label label-primary">View</a>
                <a href="#" class="label label-success">Pending</a>
                <a href="#" class="label label-danger">Delete</a> --}}
            </div>
            <div class="panel-footer">
            </div>
        </div>
        @endforeach
    </div> 
</div>
<script src="{{asset('/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script>
    $('textarea').ckeditor();
    // $('.textarea').ckeditor(); // if class is prefered.
</script>
@endsection