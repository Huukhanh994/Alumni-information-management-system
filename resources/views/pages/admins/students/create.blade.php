@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-sm-6">
                <h3 class="box-title m-b-0">Form Create Students</h3>
                <br>
                @if (count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{  $error}}    </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (\Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        <p>{{  \Session::get('success') }}</p>
                    </div>
                @endif
                <form data-toggle="validator" novalidate="true" action="{{route('students.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="code" class="control-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Code" onkeyup="show_result()">
                    </div>
                    <div class="form-group">
                        <label for="code" class="control-label">Khóa</label>
                        <input type="text" class="form-control" id="course" name="course" placeholder="Course">
                    </div>
                    <div class="form-group">
                        <label for="code" class="control-label">Class Code</label>
                        <input type="text" class="form-control" id="class_code" name="class_code" placeholder="Class Code">
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="control-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" >
                    </div>
                    <div class="form-group">
                        <label for="username" class="control-label">UserName</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="UserName" disabled>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="nation" class="control-label">Nation</label>
                        <input type="text" class="form-control" id="nation" name="nation" placeholder="Nation">
                    </div>
                    <div class="form-group">
                        <label for="tel" class="control-label">Tel</label>
                        <input type="text" class="form-control" id="tel" name="tel" placeholder="Tel">
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <label for="birthday" class="control-label">Birth</label>
                        <input type="date" class="form-control" id="birth" name="birth" placeholder="Birth">
                    </div>
                    <div class="form-group">
                        <label for="gender" class="control-label">Gender</label>
                        <input type="text" class="form-control" id="gender" name="gender" placeholder="Gender">
                    </div>
                    <div class="form-group">
                        <label for="family_tel" class="control-label">Family Tel</label>
                        <input type="text" class="form-control" id="family_tel" name="family_tel" placeholder="Family Tel">
                    </div>
                    <div class="form-group">
                        <label for="family_address" class="control-label">Family Address</label>
                        <input type="text" class="form-control" id="family_address" name="family_address" placeholder="Family Address">
                    </div>
                    <div class="form-group">
                            <label for="status_id">Chọn trạng thái:</label>
                            <select class="form-control" name="status_id" id="status_id">
                                <option value="" disabled selected>Choose</option>
                                <option name="di-hoc" value="1">Đi học</option>
                                <option name="nghi-hoc" value="2">Nghỉ học</option>
                                <option name="di-lam" value="3">Đi làm</option>
                            </select>
                        </div>
                    
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{route('students.index')}}" class="btn btn-default">Back</a>
                    </div>
                </form>
            </div>
    </div>
    <script language="javascript">
      function show_result()
      {
        // Lấy hai thẻ HTML
       	var input = document.getElementById("code");
        var div = document.getElementById("username");
        
        // Gán nội dung ô input vào thẻ div
        div.value = input.value;
      }
    
    </script>
    
@endsection